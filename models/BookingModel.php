<?php
class Booking {
    public $conn;

    public function __construct() 
    {
        $this->conn = connectDB();
    }

    // Lấy danh sách booking với tất cả thông tin chi tiết
    public function getAllDonHang() 
    {
        $sql = "SELECT 
                    don_hang.id,
                    don_hang.tour_id,
                    don_hang.hdv_id,
                    tour.ten as tour_ten,
                    hdv.hoTen as hdv_hoTen,
                    GROUP_CONCAT(khach_hang.ten SEPARATOR ', ') as khach_hang_ten,
                    don_hang.tgDatDon,
                    don_hang.datCoc,
                    don_hang.tongTien,
                    don_hang.trangThai
                FROM don_hang
                JOIN tour ON don_hang.tour_id = tour.id
                JOIN hdv ON don_hang.hdv_id = hdv.id
                LEFT JOIN don_hang_khach_hang ON don_hang.id = don_hang_khach_hang.donHang_id
                LEFT JOIN khach_hang ON don_hang_khach_hang.khachHang_id = khach_hang.id
                GROUP BY don_hang.id
                ORDER BY don_hang.id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $donHangList = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $donHangList;
    }

    // Lấy dữ liệu booking theo ID
    public function getDonHangById($id) 
    {
        $sql = "SELECT * FROM don_hang WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        $donHang = $stmt->fetch(PDO::FETCH_ASSOC);
        return $donHang;
    }

    // Lấy danh sách khách hàng chi tiết của booking
    public function getDonHangKhachHangList($donHangId)
    {
        $sql = "SELECT 
                    kh.id,
                    kh.ten,
                    kh.tuoi,
                    kh.gioiTinh,
                    kh.dienThoai,
                    kh.email,
                    dkh.trangThai_checkin
                FROM don_hang_khach_hang dkh
                JOIN khach_hang kh ON dkh.khachHang_id = kh.id
                WHERE dkh.donHang_id = :donHang_id
                ORDER BY kh.id ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['donHang_id' => $donHangId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy danh sách tất cả khách hàng
    public function getAllKhachHang()
    {
        $sql = "SELECT id, ten, dienThoai, email FROM khach_hang ORDER BY ten ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy danh sách khách hàng theo ID booking
    public function getKhachHangById($donHangId)
    {
        $sql = "SELECT 
                    kh.id,
                    kh.ten,
                    kh.tuoi,
                    kh.gioiTinh,
                    kh.dienThoai,
                    kh.email,
                    dkh.trangThai_checkin
                FROM don_hang_khach_hang dkh
                JOIN khach_hang kh ON dkh.khachHang_id = kh.id
                WHERE dkh.donHang_id = :donHang_id
                ORDER BY kh.id ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['donHang_id' => $donHangId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Thêm booking mới
    public function themDonHang($data) 
    {
        $sql = "INSERT INTO don_hang (tour_id, hdv_id, donHangKhachHang_id, tgDatDon, datCoc, tongTien, trangThai)
                VALUES (:tour_id, :hdv_id, :donHangKhachHang_id, :tgDatDon, :datCoc, :tongTien, :trangThai)";

        $stmt = $this->conn->prepare($sql);
        $result = $stmt->execute([
            'tour_id'   => $data['tour_id'] ?? null,
            'hdv_id'    => $data['hdv_id'] ?? null,
            'donHangKhachHang_id' => $data['donHangKhachHang_id'] ?? null,
            'tgDatDon'  => $data['tgDatDon'] ?? date('Y-m-d H:i:s'),
            'datCoc'    => $data['datCoc'] ?? 0,
            'tongTien'  => $data['tongTien'] ?? 0,
            'trangThai' => $data['trangThai'] ?? 'Chờ duyệt'
        ]);

        if ($result) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    // Thêm khách hàng mới
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

            if ($result) {
                return $this->conn->lastInsertId();
            }
            return false;
        } catch (PDOException $e) {
            error_log("themKhachHang error: " . $e->getMessage());
            throw new Exception("Lỗi database: " . $e->getMessage());
        }
    }

    // Liên kết đơn hàng và khách hàng
    public function themDonHangKhachHang($data) 
    {
        try {
            $sql = "INSERT INTO don_hang_khach_hang (donHang_id, khachHang_id, soPhong, ghiChuDB)
                    VALUES (:donHang_id, :khachHang_id, :soPhong, :ghiChuDB)";

            $stmt = $this->conn->prepare($sql);
            $result = $stmt->execute([
                'donHang_id' => $data['donHang_id'] ?? null,
                'khachHang_id' => $data['khachHang_id'] ?? null,
                'soPhong'    => $data['soPhong'] ?? null,
                'ghiChuDB'   => $data['ghiChuDB'] ?? null
            ]);
            
            return $result;
        } catch (PDOException $e) {
            error_log("themDonHangKhachHang error: " . $e->getMessage());
            throw new Exception("Lỗi database: " . $e->getMessage());
        }
    }

    // Cập nhật booking theo ID
    public function capNhatDonHang($id, $data) 
    {
        $sql = "UPDATE don_hang
                SET tour_id = :tour_id, hdv_id = :hdv_id, tgDatDon = :tgDatDon, datCoc = :datCoc, tongTien = :tongTien, trangThai = :trangThai
                WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'tour_id'   => $data['tour_id'] ?? null,
            'hdv_id'    => $data['hdv_id'] ?? null,
            'tgDatDon'  => $data['tgDatDon'] ?? null,
            'datCoc'    => $data['datCoc'] ?? 0,
            'tongTien'  => $data['tongTien'] ?? 0,
            'trangThai' => $data['trangThai'] ?? 'Chờ duyệt',
            'id'        => $id
        ]);
    }

    // Xóa booking theo ID
    public function xoaDonHang($id) 
    {
        try {
            // Xóa tất cả khách hàng liên kết với booking trước
            $sqlDeleteCustomers = "DELETE FROM don_hang_khach_hang WHERE donHang_id = :id";
            $stmtDeleteCustomers = $this->conn->prepare($sqlDeleteCustomers);
            $stmtDeleteCustomers->execute(['id' => $id]);
            
            // Sau đó xóa booking
            $sql = "DELETE FROM don_hang WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute(['id' => $id]);
        } catch (Exception $e) {
            error_log("Delete booking error: " . $e->getMessage());
            throw $e;
        }
    }

    // Xóa khách hàng khỏi booking
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

    // Cập nhật trạng thái check-in của khách hàng cụ thể
    public function checkInDonHang($bookingId, $customerIds = [])
    {
        try {
            if (empty($customerIds)) {
                // Nếu không có customer_ids, cập nhật tất cả
                $sql = "UPDATE don_hang_khach_hang 
                        SET trangThai_checkin = :trangThai_checkin 
                        WHERE donHang_id = :donHang_id";
                $stmt = $this->conn->prepare($sql);
                return $stmt->execute([
                    'trangThai_checkin' => 1,
                    'donHang_id' => $bookingId
                ]);
            } else {
                // Cập nhật chỉ những khách được chỉ định
                // Tạo placeholder cho tất cả customer IDs
                $placeholders = array_fill(0, count($customerIds), '?');
                $sql = "UPDATE don_hang_khach_hang 
                        SET trangThai_checkin = ? 
                        WHERE donHang_id = ? AND khachHang_id IN (" . implode(',', $placeholders) . ")";
                
                $stmt = $this->conn->prepare($sql);
                
                // Tạo array parameters: [trangThai_checkin, donHang_id, ...customerIds]
                $params = [1, $bookingId];
                $params = array_merge($params, $customerIds);
                
                $result = $stmt->execute($params);
                return $stmt->rowCount();
            }
        } catch (Exception $e) {
            error_log("CheckInDonHang error: " . $e->getMessage());
            throw $e;
        }
    }
}
?>
