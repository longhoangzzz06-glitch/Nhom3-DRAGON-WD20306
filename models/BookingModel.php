<?php
class Booking {
    public $conn;

    /* ============================================================
        A. KHỞI TẠO
    ============================================================ */
    public function __construct() 
    {
        $this->conn = connectDB();
    }

    /* ============================================================
        B. LẤY DỮ LIỆU (SELECT)
    ============================================================ */

    // Lấy danh sách booking đầy đủ thông tin

    
    public function getAllDonHang() 
    {
        $sql = "SELECT 
                    dh.id,
                    dh.tour_id,
                    dh.hdv_id,
                    dh.tgBatDau,
                    dh.tgKetThuc,
                    tour.ten AS tour_ten,
                    tour.maxKhach AS tour_maxKhach,
                    tour.gia AS tour_gia,
                    hdv.hoTen AS hdv_hoTen,
                    GROUP_CONCAT(khach_hang.ten SEPARATOR ', ') AS khach_hang_ten,
                    dh.tgDatDon,
                    dh.datCoc,
                    dh.tongTien,
                    dh.trangThai
                FROM don_hang dh
                JOIN tour ON dh.tour_id = tour.id
                JOIN hdv ON dh.hdv_id = hdv.id
                LEFT JOIN don_hang_khach_hang ON dh.id = don_hang_khach_hang.donHang_id
                LEFT JOIN khach_hang ON don_hang_khach_hang.khachHang_id = khach_hang.id
                GROUP BY dh.id
                ORDER BY dh.id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Đến khách hàng trong booking
    public function countKhachHangInDonHang($donHangId)
    {
        $sql = "SELECT COUNT(*) AS soLuongKhach
                FROM don_hang_khach_hang
                WHERE donHang_id = :donHang_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['donHang_id' => $donHangId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? (int)$result['soLuongKhach'] : 0;
    }


    // Lấy thông tin booking theo ID
    public function getDonHangById($id) 
    {
        $sql = "SELECT don_hang.*, tour.gia AS tour_gia, tour.maxKhach AS tour_maxKhach FROM don_hang JOIN tour ON don_hang.tour_id = tour.id WHERE don_hang.id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Lấy danh sách khách hàng trong 1 booking
    public function getDonHangKhachHang($donHangId)
    {
        $sql = "SELECT 
                    dkh.*, 
                    kh.id AS khachHang_id,
                    kh.ten,
                    kh.tuoi,
                    kh.gioiTinh,
                    kh.dienThoai,
                    kh.email
                FROM don_hang_khach_hang dkh
                JOIN khach_hang kh ON dkh.khachHang_id = kh.id
                WHERE dkh.donHang_id = :donHang_id
                ORDER BY dkh.id ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['donHang_id' => $donHangId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy toàn bộ khách hàng
    public function getAllKhachHang()
    {
        $sql = "SELECT id, ten, tuoi, gioiTinh, dienThoai, email FROM khach_hang ORDER BY ten ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ============================================================
        C. THÊM DỮ LIỆU (INSERT)
    ============================================================ */

    // Thêm booking
    public function themDonHang($data) 
    {
        $sql = "INSERT INTO don_hang (tour_id, hdv_id, tgBatDau, tgKetThuc, tgDatDon, datCoc, tongTien, trangThai)
                VALUES (:tour_id, :hdv_id, :tgBatDau, :tgKetThuc, :tgDatDon, :datCoc, :tongTien, :trangThai)";

        $stmt = $this->conn->prepare($sql);
        $result = $stmt->execute([
            'tour_id'   => $data['tour_id'] ?? null,
            'hdv_id'    => $data['hdv_id'] ?? null,
            'tgBatDau' => $data['tgBatDau'] ?? null,
            'tgKetThuc' => $data['tgKetThuc'] ?? null,
            'tgDatDon'  => $data['tgDatDon'] ?? date('Y-m-d H:i:s'),
            'datCoc'    => $data['datCoc'] ?? 0,
            'tongTien'  => $data['tongTien'] ?? 0,
            'trangThai' => $data['trangThai'] ?? 'Chờ duyệt'
        ]);

        return $result ? $this->conn->lastInsertId() : false;
    }

    // Thêm khách hàng
    public function themKhachHang($data) 
    {
        try {
            $sql = "INSERT INTO khach_hang (ten, tuoi, gioiTinh, dienThoai, email)
                    VALUES (:ten, :tuoi, :gioiTinh, :dienThoai, :email)";
            $stmt = $this->conn->prepare($sql);
            $result = $stmt->execute([
                'ten'        => $data['ten'] ?? '',
                'tuoi'       => $data['tuoi'] ?? '1',
                'gioiTinh'   => $data['gioiTinh'] ?? '',
                'dienThoai'  => $data['dienThoai'] ?? '',
                'email'      => $data['email'] ?? ''
            ]);

            return $result ? $this->conn->lastInsertId() : false;
        } catch (PDOException $e) {
            error_log("themKhachHang error: " . $e->getMessage());
            throw new Exception("Lỗi database: " . $e->getMessage());
        }
    }

    // Gắn khách vào đơn hàng
    public function themDonHangKhachHang($data) 
    {
        try {
            $sql = "INSERT INTO don_hang_khach_hang (donHang_id, khachHang_id, soPhong, ghiChuDB)
                    VALUES (:donHang_id, :khachHang_id, :soPhong, :ghiChuDB)";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                'donHang_id' => $data['donHang_id'] ?? null,
                'khachHang_id' => $data['khachHang_id'] ?? null,
                'soPhong'    => $data['soPhong'] ?? null,
                'ghiChuDB'   => $data['ghiChuDB'] ?? null
            ]);
        } catch (PDOException $e) {
            error_log("themDonHangKhachHang error: " . $e->getMessage());
            throw new Exception("Lỗi database: " . $e->getMessage());
        }
    }

    /* ============================================================
        D. CẬP NHẬT DỮ LIỆU (UPDATE)
    ============================================================ */

    // Cập nhật booking
        public function capNhatDonHang($id, $data)
        {
            $sql = "UPDATE don_hang
                    SET tour_id  = :tour_id,
                        hdv_id   = :hdv_id,
                        tgBatDau = :tgBatDau,
                        tgKetThuc = :tgKetThuc,
                        tgDatDon = :tgDatDon,
                        datCoc   = :datCoc,
                        tongTien = :tongTien,
                        trangThai = :trangThai
                    WHERE id = :id";

            $stmt = $this->conn->prepare($sql);

            return $stmt->execute([
                ':id'        => $id,
                ':tour_id'   => $data['tour_id']   ?? null,
                ':hdv_id'    => $data['hdv_id']    ?? null,
                ':tgBatDau'  => $data['tgBatDau']  ?? null,
                ':tgKetThuc' => $data['tgKetThuc'] ?? null,
                ':tgDatDon'  => $data['tgDatDon']  ?? null,
                ':datCoc'    => $data['datCoc']    ?? 0,
                ':tongTien'  => $data['tongTien']  ?? 0,
                ':trangThai' => $data['trangThai'] ?? 'Chờ xác nhận',
            ]);
        }

    // Check-in khách hoặc toàn bộ
    public function checkInDonHang($bookingId, $customerIds = [])
    {
        try {
            if (empty($customerIds)) {
                // Check-in tất cả khách
                $sql = "UPDATE don_hang_khach_hang 
                        SET trangThai_checkin = :trangThai_checkin 
                        WHERE donHang_id = :donHang_id";
                $stmt = $this->conn->prepare($sql);
                return $stmt->execute([
                    'trangThai_checkin' => 1,
                    'donHang_id' => $bookingId
                ]);
            } else {
                // Chỉ check-in các khách chọn lọc
                $placeholders = array_fill(0, count($customerIds), '?');
                $sql = "UPDATE don_hang_khach_hang 
                        SET trangThai_checkin = ? 
                        WHERE donHang_id = ? AND khachHang_id IN (" . implode(',', $placeholders) . ")";

                $stmt = $this->conn->prepare($sql);

                $params = array_merge([1, $bookingId], $customerIds);
                $stmt->execute($params);
                return $stmt->rowCount();
            }
        } catch (Exception $e) {
            error_log("CheckInDonHang error: " . $e->getMessage());
            throw $e;
        }
    }

    /* ============================================================
        E. XÓA DỮ LIỆU (DELETE)
    ============================================================ */

    // Xóa 1 khách khỏi booking
    public function xoaDonHangKhachHang($bookingId, $customerId)
    {
        $sql = "DELETE FROM don_hang_khach_hang 
                WHERE donHang_id = :donHang_id AND khachHang_id = :khachHang_id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'donHang_id' => $bookingId,
            'khachHang_id' => $customerId
        ]);
    }

    // Xóa booking + toàn bộ khách liên quan
    public function xoaDonHang($id) 
    {
        try {
            $sqlDeleteCustomers = "DELETE FROM don_hang_khach_hang WHERE donHang_id = :id";
            $stmtDeleteCustomers = $this->conn->prepare($sqlDeleteCustomers);
            $stmtDeleteCustomers->execute(['id' => $id]);

            $sql = "DELETE FROM don_hang WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute(['id' => $id]);

        } catch (Exception $e) {
            error_log("Delete booking error: " . $e->getMessage());
            throw $e;
        }
    }

    /* ============================================================
        F. HỖ TRỢ / TÌM KIẾM
    ============================================================ */

    // Tìm khách theo sđt hoặc email
    public function getKhachHangByPhoneOrEmail($phone, $email)
    {
        $conditions = [];
        $params = [];

        if (!empty($phone)) {
            $conditions[] = "dienThoai = :phone";
            $params[':phone'] = $phone;
        }
        if (!empty($email)) {
            $conditions[] = "email = :email";
            $params[':email'] = $email;
        }

        if (empty($conditions)) return false;

        $sql = "SELECT * FROM khach_hang WHERE " . implode(" OR ", $conditions) . " LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Lấy tất cả khách hàng CHƯA thuộc booking
    public function getKhachHangChuaThuocBooking($donHangId)
    {
        $sql = "
            SELECT kh.id, kh.ten, kh.dienThoai, kh.email
            FROM khach_hang kh
            WHERE kh.id NOT IN (
                SELECT khachHang_id 
                FROM don_hang_khach_hang 
                WHERE donHang_id = :donHang_id
            )
            ORDER BY kh.ten ASC
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['donHang_id' => $donHangId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
?>
