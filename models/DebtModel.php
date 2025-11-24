<?php

class DebtModel
{
    private $db;
    private $table = 'cong_no';
    private $paymentTable = 'cong_no_thanh_toan';

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAllDebts()
    {
        $sql = "SELECT cn.id, cn.loai, cn.doi_tuong, cn.so_tien, cn.so_tien_da_tra,
                       (cn.so_tien - cn.so_tien_da_tra) AS con_no,
                       cn.han_thanh_toan, cn.note
                FROM {$this->table} cn
                ORDER BY cn.han_thanh_toan ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDebtById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getPayments($id)
    {
        $sql = "SELECT * FROM {$this->paymentTable} WHERE cong_no_id = ? ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addPayment($debt_id, $amount, $note = null)
    {
        try {
            // Start transaction
            $this->db->beginTransaction();

            // Insert payment record
            $sql = "INSERT INTO {$this->paymentTable} (cong_no_id, so_tien, ghi_chu, created_at) 
                    VALUES (?, ?, ?, NOW())";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$debt_id, $amount, $note]);

            // Update debt paid amount
            $sql2 = "UPDATE {$this->table} SET so_tien_da_tra = so_tien_da_tra + ? WHERE id = ?";
            $stmt2 = $this->db->prepare($sql2);
            $stmt2->execute([$amount, $debt_id]);

            // Commit transaction
            $this->db->commit();

            return true;
        } catch (PDOException $e) {
            // Rollback on error
            $this->db->rollBack();
            throw new Exception("Lỗi khi thêm thanh toán: " . $e->getMessage());
        }
    }

    public function createDebt($data)
    {
        $sql = "INSERT INTO {$this->table} 
                (loai, doi_tuong, so_tien, so_tien_da_tra, han_thanh_toan, note)
                VALUES (?, ?, ?, 0, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['loai'] ?? null,
            $data['doi_tuong'] ?? null,
            $data['so_tien'] ?? 0,
            $data['han_thanh_toan'] ?? null,
            $data['note'] ?? null
        ]);
    }

    public function updateDebt($id, $data)
    {
        $sql = "UPDATE {$this->table} 
                SET loai=?, doi_tuong=?, so_tien=?, han_thanh_toan=?, note=?
                WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['loai'] ?? null,
            $data['doi_tuong'] ?? null,
            $data['so_tien'] ?? 0,
            $data['han_thanh_toan'] ?? null,
            $data['note'] ?? null,
            $id
        ]);
    }

    public function deleteDebt($id)
    {
        // First delete related payments
        $sql = "DELETE FROM {$this->paymentTable} WHERE cong_no_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);

        // Then delete debt
        $sql2 = "DELETE FROM {$this->table} WHERE id = ?";
        $stmt2 = $this->db->prepare($sql2);
        return $stmt2->execute([$id]);
    }

    public function getOutstandingDebts()
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE (so_tien - so_tien_da_tra) > 0 
                AND han_thanh_toan < NOW()
                ORDER BY han_thanh_toan ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUpcomingDebts($days = 7)
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE (so_tien - so_tien_da_tra) > 0 
                AND han_thanh_toan BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL ? DAY)
                ORDER BY han_thanh_toan ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$days]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
