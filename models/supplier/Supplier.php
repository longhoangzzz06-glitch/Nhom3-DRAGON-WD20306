<?php
class Supplier {
    private $db;
    public function __construct(PDO $db){ $this->db = $db; }

    public function create($data){
        $sql = "INSERT INTO suppliers
          (name, service_type, address, contact_name, contact_phone, contact_email, capacity, notes)
          VALUES (:name,:service_type,:address,:contact_name,:contact_phone,:contact_email,:capacity,:notes)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    public function update($id, $data){
        $data['id']=$id;
        $sql = "UPDATE suppliers SET
          name=:name, service_type=:service_type, address=:address,
          contact_name=:contact_name, contact_phone=:contact_phone,
          contact_email=:contact_email, capacity=:capacity, notes=:notes
          WHERE id=:id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    public function delete($id){
        $stmt = $this->db->prepare("DELETE FROM suppliers WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function getById($id){
        $stmt = $this->db->prepare("SELECT * FROM suppliers WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAll($limit=100, $offset=0, $filter=[]){
        $where = "1=1";
        $params = [];
        if(!empty($filter['service_type'])){ $where .= " AND service_type = :stype"; $params[':stype']=$filter['service_type']; }
        if(!empty($filter['q'])){ $where .= " AND name LIKE :q"; $params[':q']='%'.$filter['q'].'%'; }
        $sql = "SELECT * FROM suppliers WHERE $where ORDER BY name LIMIT :lim OFFSET :off";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':lim',(int)$limit,PDO::PARAM_INT);
        $stmt->bindValue(':off',(int)$offset,PDO::PARAM_INT);
        foreach($params as $k=>$v) $stmt->bindValue($k,$v);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
