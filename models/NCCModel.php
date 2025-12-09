<?php
class NCCModel {
    private $conn;

    public function __construct() 
    {
        $this->conn = connectDB();
    }

    // Lấy dữ liệu tất cả nhà cung cấp
    public function layAllNCC() 
    {
        $sql = "SELECT * FROM ncc";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $nccList = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $nccList;
    }

    // Lấy dữ liệu nhà cung cấp theo ID
    public function layNCCById($id)
    {
        $sql = "SELECT * FROM ncc WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        $ncc = $stmt->fetch(PDO::FETCH_ASSOC);
        return $ncc;
    }

    // Xóa nhà cung cấp
    public function xoaNCC($id) 
    {
        $sql = "DELETE FROM ncc WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Cập nhật nhà cung cấp
    public function suaNCC($id, $data) 
    {
        $sql = "UPDATE ncc SET ten = :ten, diaChi = :diaChi, soDienThoai = :soDienThoai, email = :email WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':ten', $data['ten']);
        $stmt->bindParam(':diaChi', $data['diaChi']);
        $stmt->bindParam(':soDienThoai', $data['soDienThoai']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Thêm nhà cung cấp
    public function themNCC($data) 
    {
        $sql = "INSERT INTO ncc (ten, diaChi, soDienThoai, email) 
                VALUES (:ten, :diaChi, :soDienThoai, :email)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':ten', $data['ten']);
        $stmt->bindParam(':diaChi', $data['diaChi']);
        $stmt->bindParam(':soDienThoai', $data['soDienThoai']);
        $stmt->bindParam(':email', $data['email']);
        return $stmt->execute();
    }

    // Lấy nhà cung cấp theo ID tour
    public function layNccByTourId($id) 
    {
        $sql = "SELECT ncc.id, ncc.ten, ncc.dvCungCap, ncc.tenDv 
                FROM ncc_tour nct
                JOIN ncc ON nct.ncc_id = ncc.id 
                WHERE nct.tour_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        $ncc = $stmt->fetch(PDO::FETCH_ASSOC);
        return $ncc;
    }
}