<?php
class SupplierDebt {
    private $db;
    public function __construct(PDO $db){ $this->db = $db; }

    public function create($data){
        $sql = "INSERT INTO supplier_debts (supplier_id, related_contract_id, amount, due_date, status, note)
                VALUES (:supplier_id,:related_contract_id,:amount,:due_date,:status,:note)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    public function getOutstandingBySupplier($supplier_id){
        $stmt = $this->db->prepare("SELECT * FROM supplier_debts WHERE supplier_id = ? AND status != 'paid' ORDER BY due_date ASC");
        $stmt->execute([$supplier_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
