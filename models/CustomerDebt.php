<?php
class CustomerDebt
{
    private $db;
    private $table = 'customer_debts';

    public function __construct()
    {
        require_once "config/database.php";
        $this->db = Database::connect();
    }

    public function getAll()
    {
        $sql = "SELECT d.*, c.customer_name, t.tour_name,
                       (d.total_price - d.paid_amount) AS remaining_debt
                FROM {$this->table} d
                JOIN customers c ON d.customer_id = c.id
                JOIN tours t ON d.tour_id = t.id
                ORDER BY d.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByCustomerId($customer_id)
    {
        $sql = "SELECT d.*, t.tour_name,
                       (d.total_price - d.paid_amount) AS remaining_debt
                FROM {$this->table} d
                JOIN tours t ON d.tour_id = t.id
                WHERE d.customer_id = ?
                ORDER BY d.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$customer_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalDebtByCustomer($customer_id)
    {
        $stmt = $this->db->prepare(
            "SELECT SUM(total_price - paid_amount) AS total_debt 
             FROM {$this->table} 
             WHERE customer_id = ?"
        );
        $stmt->execute([$customer_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (float)($result['total_debt'] ?? 0);
    }

    public function create($data)
    {
        $sql = "INSERT INTO {$this->table} 
                (customer_id, tour_id, total_price, paid_amount, last_payment_date, note)
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            $data['customer_id'] ?? null,
            $data['tour_id'] ?? null,
            (float)($data['total_price'] ?? 0),
            (float)($data['paid_amount'] ?? 0),
            $data['last_payment_date'] ?? null,
            $data['note'] ?? null
        ]);
    }

    public function update($id, $data)
    {
        $sql = "UPDATE {$this->table}
                SET customer_id=?, tour_id=?, total_price=?, paid_amount=?, last_payment_date=?, note=?, updated_at=NOW()
                WHERE id=?";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            $data['customer_id'] ?? null,
            $data['tour_id'] ?? null,
            (float)($data['total_price'] ?? 0),
            (float)($data['paid_amount'] ?? 0),
            $data['last_payment_date'] ?? null,
            $data['note'] ?? null,
            $id
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id=?");
        return $stmt->execute([$id]);
    }

    public function getOutstandingDebts()
    {
        $sql = "SELECT d.*, c.customer_name, t.tour_name,
                       (d.total_price - d.paid_amount) AS remaining_debt
                FROM {$this->table} d
                JOIN customers c ON d.customer_id = c.id
                JOIN tours t ON d.tour_id = t.id
                WHERE (d.total_price - d.paid_amount) > 0
                ORDER BY d.created_at ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addPayment($customer_debt_id, $amount)
    {
        try {
            $this->db->beginTransaction();

            // Get current debt
            $debt = $this->getById($customer_debt_id);
            if (!$debt) {
                throw new Exception("Công nợ không tồn tại");
            }

            $newPaidAmount = $debt['paid_amount'] + $amount;
            if ($newPaidAmount > $debt['total_price']) {
                throw new Exception("Số tiền thanh toán vượt quá số nợ");
            }

            // Update paid amount
            $stmt = $this->db->prepare(
                "UPDATE {$this->table} 
                 SET paid_amount = paid_amount + ?, last_payment_date = NOW()
                 WHERE id = ?"
            );
            $stmt->execute([$amount, $customer_debt_id]);

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw new Exception("Lỗi khi thêm thanh toán: " . $e->getMessage());
        }
    }
}
