<!--Dịch là: Tài chính -->
 <?php
// modules/Finance/FinanceModel.php
class FinanceModel {
    private $pdo;
    private $table = 'finance_transactions';
    private $summaryTable = 'finance_summary';

    public function __construct($pdo) {
        if (!($pdo instanceof PDO)) {
            throw new InvalidArgumentException("Constructor requires PDO instance");
        }
        $this->pdo = $pdo;
    }

    // Lấy transactions (có phân trang)
    public function getTransactions($limit = 50, $offset = 0) {
        $sql = "SELECT ft.*, t.tour_name
                FROM {$this->table} ft
                LEFT JOIN tours t ON ft.tour_id = t.id
                ORDER BY ft.created_at DESC
                LIMIT :lim OFFSET :off";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':lim', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':off', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countTransactions() {
        $stmt = $this->pdo->query("SELECT COUNT(*) AS cnt FROM {$this->table}");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)($result['cnt'] ?? 0);
    }

    public function getTransactionById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createTransaction($data) {
        $sql = "INSERT INTO {$this->table} 
                (tour_id, type, category, amount, currency, note, created_by, created_at)
                VALUES (:tour_id,:type,:category,:amount,:currency,:note,:created_by,NOW())";
        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute([
            ':tour_id' => $data['tour_id'] ?? null,
            ':type' => $data['type'],
            ':category' => $data['category'] ?? null,
            ':amount' => (float)$data['amount'],
            ':currency' => $data['currency'] ?? 'VND',
            ':note' => $data['note'] ?? null,
            ':created_by' => $data['created_by'] ?? null
        ]);
        
        if ($result) {
            $lastId = $this->pdo->lastInsertId();
            // Update daily summary
            $this->upsertDailySummary($data['tour_id'] ?? null, date('Y-m-d'));
            return $lastId;
        }
        return false;
    }

    public function updateTransaction($id, $data) {
        $sql = "UPDATE {$this->table} 
                SET tour_id=:tour_id, type=:type, category=:category, amount=:amount, 
                    currency=:currency, note=:note, updated_at=NOW()
                WHERE id=:id";
        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute([
            ':tour_id' => $data['tour_id'] ?? null,
            ':type' => $data['type'],
            ':category' => $data['category'] ?? null,
            ':amount' => (float)$data['amount'],
            ':currency' => $data['currency'] ?? 'VND',
            ':note' => $data['note'] ?? null,
            ':id' => $id
        ]);

        if ($result && isset($data['tour_id'])) {
            // Update daily summary
            $this->upsertDailySummary($data['tour_id'], date('Y-m-d'));
        }
        return $result;
    }

    public function deleteTransaction($id) {
        $transaction = $this->getTransactionById($id);
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = ?");
        $result = $stmt->execute([$id]);

        if ($result && $transaction) {
            // Update daily summary
            $this->upsertDailySummary($transaction['tour_id'], date('Y-m-d'));
        }
        return $result;
    }

    // Tổng theo tháng (dùng cho báo cáo)
    public function getMonthlySummary($year, $month) {
        $start = date('Y-m-d', strtotime("$year-$month-01"));
        $end = date('Y-m-t', strtotime($start));
        
        $sql = "SELECT ft.tour_id, t.tour_name,
                       SUM(CASE WHEN ft.type='income' THEN ft.amount ELSE 0 END) AS total_income,
                       SUM(CASE WHEN ft.type='expense' THEN ft.amount ELSE 0 END) AS total_expense
                FROM {$this->table} ft
                LEFT JOIN tours t ON ft.tour_id = t.id
                WHERE DATE(ft.created_at) BETWEEN :start AND :end
                GROUP BY ft.tour_id, t.tour_name
                ORDER BY t.tour_name ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':start' => $start, ':end' => $end]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Cập nhật/ghi tổng vào finance_summary
    public function upsertDailySummary($tour_id, $report_date) {
        if (!$tour_id) {
            return false;
        }

        // Tính tổng của ngày
        $stmt = $this->pdo->prepare("
            SELECT 
                SUM(CASE WHEN type='income' THEN amount ELSE 0 END) AS income,
                SUM(CASE WHEN type='expense' THEN amount ELSE 0 END) AS expense
            FROM {$this->table} 
            WHERE tour_id = ? AND DATE(created_at) = ?
        ");
        $stmt->execute([$tour_id, $report_date]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $income = (float)($row['income'] ?? 0);
        $expense = (float)($row['expense'] ?? 0);

        // Upsert (INSERT ... ON DUPLICATE KEY UPDATE)
        $sql = "INSERT INTO {$this->summaryTable} 
                (tour_id, report_date, total_income, total_expense, updated_at)
                VALUES (:tour_id, :report_date, :income, :expense, NOW())
                ON DUPLICATE KEY UPDATE 
                total_income = :income_upd, 
                total_expense = :expense_upd, 
                updated_at = NOW()";
        $stmt2 = $this->pdo->prepare($sql);
        return $stmt2->execute([
            ':tour_id' => $tour_id,
            ':report_date' => $report_date,
            ':income' => $income,
            ':expense' => $expense,
            ':income_upd' => $income,
            ':expense_upd' => $expense
        ]);
    }

    // Lấy báo cáo lãi lỗ theo tour
    public function getProfitLossReport($tour_id, $from_date, $to_date) {
        $sql = "SELECT
                   t.id,
                   t.tour_name,
                   SUM(CASE WHEN ft.type='income' THEN ft.amount ELSE 0 END) AS total_income,
                   SUM(CASE WHEN ft.type='expense' THEN ft.amount ELSE 0 END) AS total_expense
                FROM {$this->table} ft
                RIGHT JOIN tours t ON ft.tour_id = t.id
                WHERE t.id = :tour_id AND DATE(ft.created_at) BETWEEN :from_date AND :to_date
                GROUP BY t.id, t.tour_name";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':tour_id' => $tour_id,
            ':from_date' => $from_date,
            ':to_date' => $to_date
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Báo cáo toàn bộ theo khoảng thời gian
    public function getComprehensiveReport($from_date, $to_date) {
        $sql = "SELECT
                   COUNT(DISTINCT ft.id) AS total_transactions,
                   SUM(CASE WHEN ft.type='income' THEN ft.amount ELSE 0 END) AS total_income,
                   SUM(CASE WHEN ft.type='expense' THEN ft.amount ELSE 0 END) AS total_expense
                FROM {$this->table} ft
                WHERE DATE(ft.created_at) BETWEEN :from_date AND :to_date";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':from_date' => $from_date,
            ':to_date' => $to_date
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
