<?php
class TourModel {
    private $conn;

    public function __construct() 
    {
        $this->conn = connectDB();
    }

    // Lấy dữ liệu tất cả tour (JOIN với danh_muc để lấy tên)
    public function getAllTour() 
    {
        $sql = "SELECT t.*, dm.ten as danh_muc_ten FROM tour t 
                JOIN tour_danh_muc dm ON t.danhMuc_id = dm.id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $tourList = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $tourList;
    }

    // Lấy dữ liệu tất cả danh mục, nhà cung cấp, chính sách
    public function getAllDanhMucTour() 
    {
        $sql = "SELECT * FROM tour_danh_muc";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $danhMucList = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $danhMucList;
    }
    public function getAllNhaCungCap() 
    {
        $sql = "SELECT * FROM ncc";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $nccList = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $nccList;
    }

    // Lấy dữ liệu tour theo ID
    public function getTourById($id) {
        $sql = "SELECT * FROM tour 
                WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        $tour = $stmt->fetch(PDO::FETCH_ASSOC);
        return $tour;
    }

    // Thêm tour mới
    public function addTour($data) 
    {
        $sql = "INSERT INTO tour (
            ten, danhMuc_id, moTa, chinhSach, trangThai, gia, tgTao, nguoiTao_id
        ) VALUES (
            :ten, :danhMuc_id, :moTa, :chinhSach, :trangThai, :gia, :tgTao, :nguoiTao_id
        )";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'ten'         => $data['ten'] ?? '',
            'danhMuc_id'  => $data['danhMuc_id'] ?? null,
            'moTa'        => $data['moTa'] ?? '',
            'chinhSach'   => $data['chinhSach'] ?? null,
            'trangThai'   => $data['trangThai'] ?? 'Đang Đóng',
            'gia'         => $data['gia'] ?? 0,
            'tgTao'       => $data['tgTao'] ?? date('Y-m-d H:i:s'),
            'nguoiTao_id' => $data['nguoiTao_id'] ?? null,
        ]);
    }

    // Cập nhật thông tin tour
    public function updateTour($id, $data) {
        $sql = "UPDATE tour SET 
            ten = :ten, 
            danhMuc_id = :danhMuc_id, 
            moTa = :moTa, 
            chinhSach = :chinhSach, 
            trangThai = :trangThai, 
            gia = :gia 
        WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'ten'         => $data['ten'] ?? '',
            'danhMuc_id'  => $data['danhMuc_id'] ?? null,
            'moTa'        => $data['moTa'] ?? '',
            'chinhSach'   => $data['chinhSach'] ?? null,
            'trangThai'   => $data['trangThai'] ?? 'Đang Đóng',
            'gia'         => $data['gia'] ?? 0,
            'id'          => $id,
        ]);
    }

    // Xóa tour theo ID
    public function deleteTour($id) {
        $sql = "DELETE FROM tour WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }
}
?>