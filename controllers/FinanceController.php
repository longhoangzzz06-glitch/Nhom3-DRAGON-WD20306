<!--Dịch là: Tài chính -->
<?php
// modules/Finance/FinanceController.php
class FinanceController {
    private $model;
    private $db;

    public function __construct($db) {
        if (!($db instanceof PDO)) {
            throw new InvalidArgumentException("Constructor requires PDO instance");
        }
        $this->db = $db;
        $this->model = new FinanceModel($db);
    }

    // List transactions
    public function index() {
        try {
            $page = max(1, (int)($_GET['page'] ?? 1));
            $limit = 20;
            $offset = ($page - 1) * $limit;
            
            $transactions = $this->model->getTransactions($limit, $offset);
            $total = $this->model->countTransactions();
            $totalPages = ceil($total / $limit);
            
            require PATH_ROOT . 'views/finance/list.php';
        } catch (Exception $e) {
            header('HTTP/1.1 500 Internal Server Error');
            echo "Lỗi: " . htmlspecialchars($e->getMessage());
            exit;
        }
    }

    public function create() {
        try {
            // Lấy list tours để chọn
            $stmt = $this->db->query("SELECT id, tour_name FROM tours ORDER BY tour_name");
            $tours = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            require PATH_ROOT . 'views/finance/create.php';
        } catch (Exception $e) {
            header('HTTP/1.1 500 Internal Server Error');
            echo "Lỗi: " . htmlspecialchars($e->getMessage());
            exit;
        }
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?act=finance-list');
            exit;
        }

        // Validation
        $tour_id = $_POST['tour_id'] ?? null;
        $type = $_POST['type'] ?? null;
        $amount = $_POST['amount'] ?? null;

        if (empty($type) || empty($amount)) {
            header('Location: index.php?act=finance-create&error=missing_fields');
            exit;
        }

        try {
            $data = [
                'tour_id' => $tour_id,
                'type' => $type,
                'category' => $_POST['category'] ?? null,
                'amount' => (float) str_replace([',', ' '], ['', ''], $amount),
                'currency' => $_POST['currency'] ?? 'VND',
                'note' => $_POST['note'] ?? null,
                'created_by' => $_SESSION['user_id'] ?? null
            ];

            $this->model->createTransaction($data);
            header('Location: index.php?act=finance-list&success=1');
            exit;
        } catch (Exception $e) {
            header('Location: index.php?act=finance-create&error=db');
            exit;
        }
    }

    public function edit() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?act=finance-list');
            exit;
        }

        try {
            $tx = $this->model->getTransactionById($id);
            if (!$tx) {
                header('HTTP/1.1 404 Not Found');
                echo "Giao dịch không tồn tại";
                exit;
            }

            $stmt = $this->db->query("SELECT id, tour_name FROM tours ORDER BY tour_name");
            $tours = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            require PATH_ROOT . 'views/finance/edit.php';
        } catch (Exception $e) {
            header('HTTP/1.1 500 Internal Server Error');
            echo "Lỗi: " . htmlspecialchars($e->getMessage());
            exit;
        }
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?act=finance-list');
            exit;
        }

        $id = $_POST['id'] ?? null;
        if (!$id) {
            header('Location: index.php?act=finance-list');
            exit;
        }

        // Validation
        $type = $_POST['type'] ?? null;
        $amount = $_POST['amount'] ?? null;

        if (empty($type) || empty($amount)) {
            header('Location: index.php?act=finance-edit&id=' . $id . '&error=missing_fields');
            exit;
        }

        try {
            $data = [
                'tour_id' => $_POST['tour_id'] ?? null,
                'type' => $type,
                'category' => $_POST['category'] ?? null,
                'amount' => (float) str_replace([',', ' '], ['', ''], $amount),
                'currency' => $_POST['currency'] ?? 'VND',
                'note' => $_POST['note'] ?? null
            ];

            $this->model->updateTransaction($id, $data);
            header('Location: index.php?act=finance-list&success=updated');
            exit;
        } catch (Exception $e) {
            header('Location: index.php?act=finance-edit&id=' . $id . '&error=db');
            exit;
        }
    }

    public function delete() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?act=finance-list');
            exit;
        }

        try {
            $this->model->deleteTransaction($id);
            header('Location: index.php?act=finance-list&success=deleted');
            exit;
        } catch (Exception $e) {
            header('Location: index.php?act=finance-list&error=delete_failed');
            exit;
        }
    }

    // Báo cáo lãi lỗ cho 1 tour
    public function report() {
        try {
            $tour_id = $_GET['tour_id'] ?? null;
            $from = $_GET['from'] ?? date('Y-m-01');
            $to = $_GET['to'] ?? date('Y-m-t');

            // Validate date format
            if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $from) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $to)) {
                $from = date('Y-m-01');
                $to = date('Y-m-t');
            }

            $stmt = $this->db->query("SELECT id, tour_name FROM tours ORDER BY tour_name");
            $tours = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $report = null;
            if ($tour_id) {
                $report = $this->model->getProfitLossReport($tour_id, $from, $to);
            }

            require PATH_ROOT . 'views/finance/report.php';
        } catch (Exception $e) {
            header('HTTP/1.1 500 Internal Server Error');
            echo "Lỗi: " . htmlspecialchars($e->getMessage());
            exit;
        }
    }

    // Báo cáo tổng hợp theo khoảng thời gian
    public function comprehensiveReport() {
        try {
            $from = $_GET['from'] ?? date('Y-m-01');
            $to = $_GET['to'] ?? date('Y-m-t');

            // Validate date format
            if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $from) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $to)) {
                $from = date('Y-m-01');
                $to = date('Y-m-t');
            }

            $report = $this->model->getComprehensiveReport($from, $to);
            
            require PATH_ROOT . 'views/finance/comprehensive_report.php';
        } catch (Exception $e) {
            header('HTTP/1.1 500 Internal Server Error');
            echo "Lỗi: " . htmlspecialchars($e->getMessage());
            exit;
        }
    }

    // Cron: tổng hợp tất cả tour ngày hôm qua
    public function cronDailySummary() {
        try {
            $stmt = $this->db->query("SELECT id FROM tours");
            $tours = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $yesterday = date('Y-m-d', strtotime('-1 day'));

            foreach ($tours as $t) {
                $this->model->upsertDailySummary($t['id'], $yesterday);
            }

            // Log success (có thể ghi vào file hoặc DB)
            echo json_encode([
                'success' => true,
                'message' => "Daily summary updated for $yesterday",
                'tours_processed' => count($tours)
            ]);
        } catch (Exception $e) {
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]);
            exit;
        }
    }
}
