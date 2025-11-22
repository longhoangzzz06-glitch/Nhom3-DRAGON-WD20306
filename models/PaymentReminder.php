<?php

class PaymentReminder
{
    private $db;
    private $table = 'payment_reminders';

    public function __construct($db)
    {
        $this->db = $db;
    }

    // Lấy tất cả nhắc hạn
    public function getAll()
    {
        $sql = "SELECT r.*, s.name AS supplier_name, c.contract_number 
                FROM {$this->table} r
                JOIN suppliers s ON r.supplier_id = s.id
                JOIN contracts c ON r.contract_id = c.id
                ORDER BY r.due_date ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy các nhắc hạn đến hạn
    public function getDueToday()
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE due_date = CURDATE() AND status='pending'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy các nhắc hạn trễ hạn
    public function getOverdue()
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE due_date < CURDATE() AND status='pending'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Tạo nhắc hạn
    public function create($data)
    {
        $sql = "INSERT INTO {$this->table} 
                (supplier_id, contract_id, amount, due_date, note)
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['supplier_id'] ?? null,
            $data['contract_id'] ?? null,
            $data['amount'] ?? null,
            $data['due_date'] ?? null,
            $data['note'] ?? null
        ]);
    }

    public function updateStatus($id, $status)
    {
        $sql = "UPDATE {$this->table} SET status=? WHERE id=?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$status, $id]);
    }
}
