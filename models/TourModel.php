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
                LEFT JOIN tour_danh_muc dm ON t.danhMuc_id = dm.id";
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
    public function getAllChinhSach() 
    {
        $sql = "SELECT * FROM tour_chinh_sach";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $chinhSachList = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $chinhSachList;
    }

    // Lấy dữ liệu tour theo ID
    public function getTourById($id) {
        $sql = "SELECT * FROM tour WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        $tour = $stmt->fetch(PDO::FETCH_ASSOC);
        return $tour;
    }

    // Thêm tour mới
    public function addTour($data) 
    {
        $sql = "INSERT INTO tour (
            ten, danhMuc_id, moTa, chinhSach_id, ncc_id, trangThai, gia, tgBatDau, tgKetThuc, tgTao, nguoiTao_id
        ) VALUES (
            :ten, :danhMuc_id, :moTa, :chinhSach_id, :ncc_id, :trangThai, :gia, :tgBatDau, :tgKetThuc, :tgTao, :nguoiTao_id
        )";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'ten'         => $data['ten'] ?? '',
            'danhMuc_id'  => $data['danhMuc_id'] ?? null,
            'moTa'        => $data['moTa'] ?? '',
            'chinhSach_id'=> $data['chinhSach_id'] ?? null,
            'ncc_id'      => $data['ncc_id'] ?? null,
            'trangThai'   => $data['trangThai'] ?? 'Đang Đóng',
            'gia'         => $data['gia'] ?? 0,
            'tgBatDau'    => $data['tgBatDau'] ?? null,
            'tgKetThuc'   => $data['tgKetThuc'] ?? null,
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
            chinhSach_id = :chinhSach_id, 
            ncc_id = :ncc_id, 
            trangThai = :trangThai, 
            gia = :gia, 
            tgBatDau = :tgBatDau, 
            tgKetThuc = :tgKetThuc 
        WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'ten'          => $data['ten'] ?? '',
            'danhMuc_id'  => $data['danhMuc_id'] ?? null,
            'moTa'        => $data['moTa'] ?? '',
            'chinhSach_id'=> $data['chinhSach_id'] ?? null,
            'ncc_id'      => $data['ncc_id'] ?? null,
            'trangThai'   => $data['trangThai'] ?? 'Đang Đóng',
            'gia'         => $data['gia'] ?? 0,
            'tgBatDau'    => $data['tgBatDau'] ?? null,
            'tgKetThuc'   => $data['tgKetThuc'] ?? null,
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