<?php
class Contract
{
    private $db;
    private $table = 'contracts';

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function all()
    {
        $sql = "SELECT c.*, s.name AS supplier_name 
                FROM {$this->table} c 
                JOIN suppliers s ON c.supplier_id = s.id
                ORDER BY c.id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function store($data)
    {
        $sql = "INSERT INTO {$this->table} (supplier_id, contract_number, start_date, end_date, payment_due, file_path)
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['supplier_id'] ?? null,
            $data['contract_number'] ?? null,
            $data['start_date'] ?? null,
            $data['end_date'] ?? null,
            $data['payment_due'] ?? null,
            $data['file_path'] ?? null,
        ]);
    }

    public function update($id, $data)
    {
        $sql = "UPDATE {$this->table} 
                SET supplier_id=?, contract_number=?, start_date=?, end_date=?, payment_due=?, file_path=?
                WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['supplier_id'] ?? null,
            $data['contract_number'] ?? null,
            $data['start_date'] ?? null,
            $data['end_date'] ?? null,
            $data['payment_due'] ?? null,
            $data['file_path'] ?? null,
            $id
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function getExpiringContracts($days = 30)
    {
        $sql = "SELECT c.*, s.name AS supplier_name 
                FROM {$this->table} c
                JOIN suppliers s ON c.supplier_id = s.id
                WHERE DATEDIFF(c.end_date, CURDATE()) <= ?
                AND c.end_date >= CURDATE()
                ORDER BY c.end_date ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$days]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
