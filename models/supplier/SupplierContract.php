<?php
class SupplierContract {
    private $db;
    public function __construct(PDO $db){ $this->db = $db; }

    public function create($data){
        $sql = "INSERT INTO supplier_contracts
            (supplier_id, title, start_date, end_date, terms, contract_file, total_value, status)
            VALUES (:supplier_id,:title,:start_date,:end_date,:terms,:contract_file,:total_value,:status)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    public function update($id,$data){
        $data['id']=$id;
        $sql = "UPDATE supplier_contracts SET
            title=:title, start_date=:start_date, end_date=:end_date, terms=:terms,
            contract_file=:contract_file, total_value=:total_value, status=:status
            WHERE id=:id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    public function getBySupplier($supplier_id){
        $stmt = $this->db->prepare("SELECT * FROM supplier_contracts WHERE supplier_id = ? ORDER BY start_date DESC");
        $stmt->execute([$supplier_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id){
        $stmt = $this->db->prepare("SELECT * FROM supplier_contracts WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
