<?php

class Supplier
{
    private $db;
    private $table = "nha_cung_cap";

    public function __construct()
    {
        $this->db = connectDB();
    }

    // Lấy danh sách + tìm kiếm + phân trang
    public function getAll($keyword = "", $service = "", $limit = 10, $offset = 0)
    {
        $sql = "SELECT * FROM {$this->table} WHERE 1";
        $params = [];

        if ($keyword !== "") {
            $sql .= " AND ten LIKE :kw";
            $params[':kw'] = "%$keyword%";
        }

        if ($service !== "") {
            $sql .= " AND loai_dich_vu LIKE :sv";
            $params[':sv'] = "%$service%";
        }

        $sql .= " ORDER BY id DESC LIMIT :offset, :limit";

        $stmt = $this->db->prepare($sql);

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        $stmt->bindValue(":offset", (int)$offset, PDO::PARAM_INT);
        $stmt->bindValue(":limit", (int)$limit, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Đếm số bản ghi
    public function count($keyword = "", $service = "")
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE 1";

        if ($keyword !== "") {
            $sql .= " AND ten LIKE '%$keyword%'";
        }

        if ($service !== "") {
            $sql .= " AND loai_dich_vu LIKE '%$service%'";
        }

        return $this->db->query($sql)->fetch(PDO::FETCH_ASSOC)['total'];
    }

    // Lấy 1 bản ghi
    public function find($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Thêm mới
    public function insert($data)
    {
        try {
            $sql = "INSERT INTO {$this->table}
                    (ten, loai_dich_vu, dien_thoai, email, dia_chi, ghi_chu, logo)
                    VALUES (?, ?, ?, ?, ?, ?, ?)";

            $stmt = $this->db->prepare($sql);

            $execData = [
                $data['ten'],
                $data['loai_dich_vu'],
                $data['dien_thoai'],
                $data['email'],
                $data['dia_chi'],
                $data['ghi_chu'],
                $data['logo']
            ];

            return $stmt->execute($execData);

        } catch (PDOException $e) {
            echo "Lỗi khi INSERT: " . $e->getMessage();
            return false;
        }
    }

    // Cập nhật
    public function update($id, $data)
    {
        $sql = "UPDATE {$this->table}
                SET ten = :ten,
                    loai_dich_vu = :loai_dich_vu,
                    dien_thoai = :dien_thoai,
                    email = :email,
                    dia_chi = :dia_chi,
                    ghi_chu = :ghi_chu,
                    logo = :logo
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        $data['id'] = $id;

        return $stmt->execute($data);
    }

    // Xóa
    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
