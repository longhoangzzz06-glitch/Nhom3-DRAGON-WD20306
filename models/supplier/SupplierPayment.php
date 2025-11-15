<?php
class SupplierPayment {
    private $db;
    public function __construct(PDO $db){ $this->db = $db; }

    public function create($data){
        $sql = "INSERT INTO supplier_payments (supplier_id, contract_id, amount, currency, payment_date, method, invoice_no, notes, created_by)
                VALUES (:supplier_id,:contract_id,:amount,:currency,:payment_date,:method,:invoice_no,:notes,:created_by)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    public function getBySupplier($supplier_id){
        $stmt = $this->db->prepare("SELECT * FROM supplier_payments WHERE supplier_id = ? ORDER BY payment_date DESC");
        $stmt->execute([$supplier_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalPaidByContract($contract_id){
        $stmt = $this->db->prepare("SELECT SUM(amount) as paid FROM supplier_payments WHERE contract_id = ?");
        $stmt->execute([$contract_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['paid'] ?? 0;
    }
}
