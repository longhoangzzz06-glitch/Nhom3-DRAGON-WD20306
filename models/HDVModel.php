<?php
// models/HDVModel.php
class HDVModel
{
    public $conn;
    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function getAllHDV()
    {
        $sql = "SELECT hdv.*, hdv_nhom.ten as nhom_ten 
                FROM hdv 
                LEFT JOIN hdv_nhom ON hdv.nhomHDV_id = hdv_nhom.id 
                GROUP BY hdv.id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllNhomHDV()
    {
        $sql = "SELECT * FROM hdv_nhom";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy HDV kèm tên tài khoản (nếu có)
    public function getHDVById($id)
    {
        $sql = "SELECT hdv.*, tai_khoan.tenTk AS tenTaiKhoan, tai_khoan.mk AS matKhau, tai_khoan.id AS taiKhoan_id
                FROM hdv
                LEFT JOIN tai_khoan ON hdv.taiKhoan_id = tai_khoan.id
                WHERE hdv.id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Thêm HDV (giữ nguyên như trước)
    public function addHDV($data)
    {
        try {
            $this->conn->beginTransaction();

            $sqlTK = "INSERT INTO tai_khoan (tenTk, mk, chucVu)
                      VALUES (:tenTk, :mk, 'hdv')";
            $stmtTK = $this->conn->prepare($sqlTK);
            $stmtTK->execute([
                'tenTk' => $data['tenTk'],
                'mk'    => password_hash($data['mk'], PASSWORD_DEFAULT)
            ]);
            $taiKhoanId = $this->conn->lastInsertId();

            $sql = "INSERT INTO hdv (
                        hoTen, ngaySinh, anh, dienThoai, email, 
                        ngonNgu, kinhNghiem, nhomHDV_id,
                        sucKhoe, trangThai, taiKhoan_id
                    ) VALUES (
                        :hoTen, :ngaySinh, :anh, :dienThoai, :email,
                        :ngonNgu, :kinhNghiem, :nhomHDV_id,
                        :sucKhoe, :trangThai, :taiKhoan_id
                    )";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                'hoTen'        => $data['hoTen'] ?? '',
                'ngaySinh'     => $data['ngaySinh'] ?? null,
                'anh'          => $data['anh'] ?? '',
                'dienThoai'    => $data['dienThoai'] ?? '',
                'email'        => $data['email'] ?? '',
                'ngonNgu'      => $data['ngonNgu'] ?? '',
                'kinhNghiem'   => $data['kinhNghiem'] ?? 0,
                'nhomHDV_id'   => $data['nhomHDV_id'] ?? null,
                'sucKhoe'      => $data['sucKhoe'] ?? '',
                'trangThai'    => $data['trangThai'] ?? 'Đang hoạt động',
                'taiKhoan_id'  => $taiKhoanId,
            ]);

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            throw $e;
        }
    }

    public function getPhotoById($id)
    {
        $sql = "SELECT anh FROM hdv WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        $r = $stmt->fetch(PDO::FETCH_ASSOC);
        return $r ? $r['anh'] : null;
    }

    public function deleteHDV($id)
    {
        // Trước hết kiểm tra HDV còn tour không
        if ($this->countToursByHDV($id) > 0) {
            return false; // Không xóa DB nếu còn tour
        }

        $sql = "DELETE FROM hdv WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }


    // Tính số tour đã phân công cho HDV
    public function countToursByHDV($hdvId)
    {
        $sql = "SELECT COUNT(DISTINCT tour_id) as tour_count FROM don_hang WHERE hdv_id = :hdv_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['hdv_id' => $hdvId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? intval($result['tour_count']) : 0;
    }

    // Cập nhật HDV
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
                    trangThai = :trangThai,
                    taiKhoan_id = :taiKhoan_id
                WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'hoTen'        => $data['hoTen'] ?? '',
            'ngaySinh'     => $data['ngaySinh'] ?? null,
            'anh'          => $data['anh'] ?? '',
            'dienThoai'    => $data['dienThoai'] ?? '',
            'email'        => $data['email'] ?? '',
            'ngonNgu'      => $data['ngonNgu'] ?? '',
            'kinhNghiem'   => $data['kinhNghiem'] ?? 0,
            'nhomHDV_id'   => $data['nhomHDV_id'] ?? null,
            'sucKhoe'      => $data['sucKhoe'] ?? '',
            'trangThai'    => $data['trangThai'] ?? 'Đang hoạt động',
            'taiKhoan_id'  => $data['taiKhoan_id'] ?? null,
            'id'           => $id,
        ]);
    }
    // Lấy danh sách tour được phân công cho HDV
    public function getToursByHDV($hdvId)
    {
        $sql = "SELECT tour.*,
                COUNT(DISTINCT dh.id) AS booking_count,
                COUNT(DISTINCT dhkh.khachHang_id) AS customer_count
            FROM (
                SELECT 
                    t.id,
                    t.ten,
                    t.gia,
                    t.moTa,
                    dm.ten AS danhMuc,
                    MIN(dh.tgBatDau) AS tgBatDau,
                    MAX(dh.tgKetThuc) AS tgKetThuc
                FROM don_hang dh
                INNER JOIN tour t ON dh.tour_id = t.id
                LEFT JOIN tour_danh_muc dm ON t.danhMuc_id = dm.id
                WHERE dh.hdv_id = :hdv_id
                GROUP BY t.id
            ) AS tour
            LEFT JOIN don_hang dh ON dh.tour_id = tour.id
            LEFT JOIN don_hang_khach_hang dhkh ON dh.id = dhkh.donHang_id
            GROUP BY tour.id
            ORDER BY tour.tgBatDau DESC";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['hdv_id' => $hdvId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
