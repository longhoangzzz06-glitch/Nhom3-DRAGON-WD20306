<?php
require_once './commons/env.php';

class TourDetailModel
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    // Lấy thông tin chi tiết tour
    public function getTourInfo($tourId)
    {
        $sql = "SELECT 
                    t.id,
                    t.ten,
                    t.gia,
                    t.tgBatDau,
                    t.tgKetThuc,
                    t.moTa,
                    dm.ten as danhMuc
                FROM tour t
                LEFT JOIN tour_danh_muc dm ON t.danhMuc_id = dm.id
                WHERE t.id = :tour_id
                LIMIT 1";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['tour_id' => $tourId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Lấy danh sách khách hàng của tour
    public function getCustomersByTour($tourId)
    {
        $sql = "SELECT 
                    kh.id as khachHang_id,
                    kh.ten as khachHang_ten,
                    kh.tuoi,
                    kh.gioiTinh,
                    kh.dienThoai,
                    kh.email,
                    dhkh.trangThai_checkin,
                    dhkh.soPhong,
                    dhkh.ghiChuDB
                FROM don_hang dh
                INNER JOIN don_hang_khach_hang dhkh ON dh.id = dhkh.donHang_id
                INNER JOIN khach_hang kh ON dhkh.khachHang_id = kh.id
                WHERE dh.tour_id = :tour_id
                ORDER BY kh.ten ASC";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['tour_id' => $tourId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy lịch trình tour
    public function getItineraryByTour($tourId)
    {
        $sql = "SELECT 
                    thuTu as day,
                    ten as title,
                    moTa as activities
                FROM dia_diem
                WHERE tour_id = :tour_id 
                AND loai = 'destination'
                ORDER BY thuTu ASC";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['tour_id' => $tourId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy thống kê tổng quan của tour
    public function getTourStats($tourId)
    {
        $sql = "SELECT 
                    COUNT(DISTINCT dhkh.khachHang_id) as total_customers,
                    SUM(CASE WHEN dhkh.trangThai_checkin = 'present' THEN 1 ELSE 0 END) as checked_in,
                    COUNT(DISTINCT ycdb.id) as total_requirements,
                    COUNT(DISTINCT nkt.id) as total_diary_entries
                FROM don_hang dh
                LEFT JOIN don_hang_khach_hang dhkh ON dh.id = dhkh.donHang_id
                LEFT JOIN yeu_cau_dac_biet ycdb ON dh.tour_id = ycdb.tour_id
                LEFT JOIN nhat_ky_tour nkt ON dh.tour_id = nkt.tour_id
                WHERE dh.tour_id = :tour_id";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['tour_id' => $tourId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
