<?php

class Supplier
{
    private $db;
    private $table = "suppliers";

    public function __construct()
    {
        $this->db = connectDB();
    }

    // Lấy danh sách có tìm kiếm + phân trang
    public function getAll($keyword = "", $service = "", $limit = 10, $offset = 0)
    {
        $sql = "SELECT * FROM {$this->table} WHERE 1";

        if ($keyword !== "") {
            $sql .= " AND name LIKE :kw";
        }
        if ($service !== "") {
            $sql .= " AND service_type LIKE :sv";
        }

        $sql .= " ORDER BY id DESC LIMIT :offset, :limit";

        $stmt = $this->db->prepare($sql);

        if ($keyword !== "") {
            $stmt->bindValue(":kw", "%$keyword%");
        }
        if ($service !== "") {
            $stmt->bindValue(":sv", "%$service%");
        }

        $stmt->bindValue(":offset", $offset, PDO::PARAM_INT);
        $stmt->bindValue(":limit", $limit, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Đếm tổng bản ghi dùng phân trang
    public function count($keyword = "", $service = "")
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE 1";

        if ($keyword !== "") {
            $sql .= " AND name LIKE '%$keyword%'";
        }
        if ($service !== "") {
            $sql .= " AND service_type LIKE '%$service%'";
        }

        return $this->db->query($sql)->fetch(PDO::FETCH_ASSOC)['total'];
    }

    // Lấy 1 supplier
    public function find($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Thêm
    public function insert($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO {$this->table}(name, service_type, phone, email, address, note, logo)
            VALUES (:name, :service_type, :phone, :email, :address, :note, :logo)
        ");

        return $stmt->execute($data);
    }

    // Update
    public function update($id, $data)
    {
        $data['id'] = $id;
        $stmt = $this->db->prepare("
            UPDATE {$this->table}
            SET name=:name, service_type=:service_type, phone=:phone, email=:email,
                address=:address, note=:note, logo=:logo
            WHERE id=:id
        ");

        return $stmt->execute($data);
    }

    // Xóa
    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
