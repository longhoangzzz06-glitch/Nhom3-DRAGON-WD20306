<?php 
// Có class chứa các function thực thi tương tác với cơ sở dữ liệu 
class HDVModel 
{
    public $conn;
    public function __construct()
    {
        $this->conn = connectDB();
    }

    // Lấy dữ liệu tất cả hướng dẫn viên
    public function getAllHDV()
    {
        $sql = "SELECT hdv.*, hdv_nhom.ten as nhom_ten FROM hdv LEFT JOIN hdv_nhom ON hdv.nhomHDV_id = hdv_nhom.id GROUP BY hdv.id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $hdvList = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $hdvList;
    }

    public function getAllNhomHDV()
    {
        $sql = "SELECT * FROM hdv_nhom";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $nhomHDV = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $nhomHDV;
    }

    // Lấy dữ liệu hướng dẫn viên theo ID
    public function getHDVById($id)
    {
        $sql = "SELECT hdv.*, hdv_nhom.ten FROM hdv LEFT JOIN hdv_nhom ON hdv.nhomHDV_id = hdv_nhom.id WHERE hdv.id = :id GROUP BY hdv.id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        $hdv = $stmt->fetch(PDO::FETCH_ASSOC);
        return $hdv;
    }

    // Thêm hướng dẫn viên mới
    public function addHDV($data)
    {
        $sql = "INSERT INTO hdv (
                    hoTen, ngaySinh, anh, dienThoai, email, 
                    ngonNgu, kinhNghiem, nhomHDV_id,
                    sucKhoe, trangThai
                ) VALUES (
                    :hoTen, :ngaySinh, :anh, :dienThoai, :email,
                    :ngonNgu, :kinhNghiem, :nhomHDV_id,
                    :sucKhoe, :trangThai
                )";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            'hoTen'      => $data['hoTen'] ?? '',
            'ngaySinh'   => $data['ngaySinh'] ?? null,
            'anh'        => $data['anh'] ?? '',
            'dienThoai'  => $data['dienThoai'] ?? '',
            'email'      => $data['email'] ?? '',
            'ngonNgu'    => $data['ngonNgu'] ?? '',
            'kinhNghiem' => $data['kinhNghiem'] ?? 0,
            'nhomHDV_id' => $data['nhomHDV_id'] ?? null,
            'sucKhoe'    => $data['sucKhoe'] ?? '',
            'trangThai'  => $data['trangThai'] ?? 'Đang hoạt động',
        ]);
    }
    
    // Lấy ảnh theo ID để xóa file
    public function getPhotoById($id)
    {
        $sql = "SELECT anh FROM hdv WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['anh'] : null;
    }

    // Xóa hướng dẫn viên theo ID
    public function deleteHDV($id)
    {
        $anh = $this->getPhotoById($id);
        if ($anh) {
            $anhPath = 'uploads/img_HDV/' . $anh;
            if (file_exists($anhPath)) {
                unlink($anhPath);
            }
        }
        $sql = "DELETE FROM hdv WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    // Cập nhật thông tin hướng dẫn viên
    public function updateHDV($id, $data)
    {
        $sql = "UPDATE hdv SET 
                    hoTen = :hoTen, 
                    ngaySinh = :ngaySinh, 
                    anh = :anh, 
                    dienThoai = :dienThoai, 
                    email = :email, 
                    ngonNgu = :ngonNgu, 
                    kinhNghiem = :kinhNghiem, 
                    nhomHDV_id = :nhomHDV_id,
                    sucKhoe = :sucKhoe, 
                    trangThai = :trangThai 
                WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'hoTen'      => $data['hoTen'] ?? '',
            'ngaySinh'   => $data['ngaySinh'] ?? null,
            'anh'        => $data['anh'] ?? '',
            'dienThoai'  => $data['dienThoai'] ?? '',
            'email'      => $data['email'] ?? '',
            'ngonNgu'    => $data['ngonNgu'] ?? '',
            'kinhNghiem' => $data['kinhNghiem'] ?? 0,
            'nhomHDV_id' => $data['nhomHDV_id'] ?? null,
            'sucKhoe'    => $data['sucKhoe'] ?? '',
            'trangThai'  => $data['trangThai'] ?? 'Đang hoạt động',
            'id'         => $id,
        ]);
    }

    // Lấy danh sách tour được phân công cho HDV
    public function getToursByHDV($hdvId)
    {
        $sql = "SELECT 
                    t.id,
                    t.ten,
                    t.gia,
                    t.tgBatDau,
                    t.tgKetThuc,
                    t.moTa,
                    dm.ten as danhMuc,
                    COUNT(DISTINCT dh.id) as booking_count,
                    COUNT(DISTINCT dhkh.khachHang_id) as customer_count
                FROM don_hang dh
                INNER JOIN tour t ON dh.tour_id = t.id
                LEFT JOIN tour_danh_muc dm ON t.danhMuc_id = dm.id
                LEFT JOIN don_hang_khach_hang dhkh ON dh.id = dhkh.donHang_id
                WHERE dh.hdv_id = :hdv_id
                GROUP BY t.id, t.ten, t.gia, t.tgBatDau, t.tgKetThuc, t.moTa, dm.ten
                ORDER BY t.tgBatDau DESC";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['hdv_id' => $hdvId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
