<?php
class SupplierQuote {
    private $db;
    public function __construct(PDO $db){ $this->db = $db; }

    public function create($data){
        $sql = "INSERT INTO supplier_quotes (supplier_id, quote_title, service_description, unit_price, currency, valid_from, valid_to, quote_file)
                VALUES (:supplier_id,:quote_title,:service_description,:unit_price,:currency,:valid_from,:valid_to,:quote_file)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    public function getBySupplier($supplier_id){
        $stmt = $this->db->prepare("SELECT * FROM supplier_quotes WHERE supplier_id = ? ORDER BY created_at DESC");
        $stmt->execute([$supplier_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function compareForService($service_name){
        $stmt = $this->db->prepare("SELECT s.id, s.name, q.unit_price, q.currency, q.quote_title 
             FROM supplier_quotes q JOIN suppliers s ON q.supplier_id = s.id
             WHERE q.service_description LIKE :svc ORDER BY q.unit_price ASC");
        $stmt->execute([':svc'=>'%'.$service_name.'%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
