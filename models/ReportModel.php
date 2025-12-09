<?php
/**
 * ReportModel - Xử lý truy vấn báo cáo vận hành tour
 * 
 * Lưu ý: Model này chỉ tính doanh thu vì database không có dữ liệu chi phí
 */
class ReportModel {
    public $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    /**
     * Lấy tổng hợp doanh thu, chi phí, lợi nhuận theo khoảng thời gian
     * Chi phí = Tổng (Giá tour × Số booking đã hoàn thành)
     * Lợi nhuận = Doanh thu - Chi phí
     */
    public function getReportSummary($fromDate = null, $toDate = null) {
        $sql = "SELECT 
                    COALESCE(SUM(dh.tongTien), 0) as total_revenue,
                    COUNT(DISTINCT dh.id) as total_bookings,
                    COALESCE(SUM(t.gia), 0) as total_cost,
                    (COALESCE(SUM(dh.tongTien), 0) - COALESCE(SUM(t.gia), 0)) as total_profit
                FROM don_hang dh
                LEFT JOIN tour t ON dh.tour_id = t.id
                WHERE dh.trangThai = 'Đã hoàn thành'";
        
        if ($fromDate) {
            $sql .= " AND DATE(dh.tgDatDon) >= :fromDate";
        }
        
        if ($toDate) {
            $sql .= " AND DATE(dh.tgDatDon) <= :toDate";
        }

        $stmt = $this->conn->prepare($sql);
        if ($fromDate) $stmt->bindParam(':fromDate', $fromDate);
        if ($toDate) $stmt->bindParam(':toDate', $toDate);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy chi tiết từng tour với doanh thu, chi phí, lợi nhuận, số booking, số khách
     * Chi phí = Giá tour (t.gia) × Số booking đã hoàn thành
     * Lợi nhuận = Doanh thu - Chi phí
     */
    public function getTourReports($fromDate = null, $toDate = null) {
        $sql = "SELECT 
                    t.id,
                    t.ten as name,
                    t.gia as tour_price,
                    td.ten as category_name,
                    COALESCE(SUM(CASE WHEN dh.trangThai = 'Đã hoàn thành' THEN dh.tongTien ELSE 0 END), 0) as revenue,
                    COUNT(DISTINCT CASE WHEN dh.trangThai = 'Đã hoàn thành' THEN dh.id END) as bookings,
                    COUNT(DISTINCT CASE WHEN dh.trangThai = 'Đã hoàn thành' THEN dhkh.khachHang_id END) as total_customers,
                    (t.gia * COUNT(DISTINCT CASE WHEN dh.trangThai = 'Đã hoàn thành' THEN dh.id END)) as total_cost,
                    (COALESCE(SUM(CASE WHEN dh.trangThai = 'Đã hoàn thành' THEN dh.tongTien ELSE 0 END), 0) - 
                     (t.gia * COUNT(DISTINCT CASE WHEN dh.trangThai = 'Đã hoàn thành' THEN dh.id END))) as profit
                FROM tour t
                LEFT JOIN tour_danh_muc td ON t.danhMuc_id = td.id
                LEFT JOIN don_hang dh ON t.id = dh.tour_id";
        
        if ($fromDate || $toDate) {
            $sql .= " AND (1=1";
            if ($fromDate) $sql .= " AND DATE(dh.tgDatDon) >= :fromDate";
            if ($toDate) $sql .= " AND DATE(dh.tgDatDon) <= :toDate";
            $sql .= ")";
        }

        $sql .= " LEFT JOIN don_hang_khach_hang dhkh ON dh.id = dhkh.donHang_id
                  GROUP BY t.id, t.ten, t.gia, td.ten
                  ORDER BY revenue DESC";

        $stmt = $this->conn->prepare($sql);
        if ($fromDate) $stmt->bindParam(':fromDate', $fromDate);
        if ($toDate) $stmt->bindParam(':toDate', $toDate);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy KPI Dashboard
     */
    public function getDashboardKPI($fromDate = null, $toDate = null) {
        $kpi = [];
        
        // Tổng số tour đang hoạt động
        $sql = "SELECT COUNT(*) as total_tours FROM tour WHERE trangThai = 'Đang Hoạt Động'";
        $stmt = $this->conn->query($sql);
        $kpi['total_tours'] = $stmt->fetch(PDO::FETCH_ASSOC)['total_tours'];
        
        // Thống kê booking
        $sql = "SELECT 
                    COUNT(*) as total_bookings,
                    SUM(CASE WHEN trangThai = 'Đã hoàn thành' THEN 1 ELSE 0 END) as confirmed_bookings,
                    SUM(CASE WHEN trangThai = 'Chờ duyệt' THEN 1 ELSE 0 END) as pending_bookings,
                    AVG(CASE WHEN trangThai = 'Đã hoàn thành' THEN tongTien ELSE NULL END) as avg_booking_value
                FROM don_hang 
                WHERE 1=1";
        
        if ($fromDate) $sql .= " AND DATE(tgDatDon) >= :fromDate";
        if ($toDate) $sql .= " AND DATE(tgDatDon) <= :toDate";
        
        $stmt = $this->conn->prepare($sql);
        if ($fromDate) $stmt->bindParam(':fromDate', $fromDate);
        if ($toDate) $stmt->bindParam(':toDate', $toDate);
        $stmt->execute();
        
        $bookingStats = $stmt->fetch(PDO::FETCH_ASSOC);
        $kpi = array_merge($kpi, $bookingStats);
        
        // Tổng số khách
        $sql = "SELECT COUNT(DISTINCT dhkh.khachHang_id) as total_customers
                FROM don_hang_khach_hang dhkh
                JOIN don_hang dh ON dhkh.donHang_id = dh.id
                WHERE dh.trangThai = 'Đã hoàn thành'";
        
        if ($fromDate) $sql .= " AND DATE(dh.tgDatDon) >= :fromDate";
        if ($toDate) $sql .= " AND DATE(dh.tgDatDon) <= :toDate";
        
        $stmt = $this->conn->prepare($sql);
        if ($fromDate) $stmt->bindParam(':fromDate', $fromDate);
        if ($toDate) $stmt->bindParam(':toDate', $toDate);
        $stmt->execute();
        
        $kpi['total_customers'] = $stmt->fetch(PDO::FETCH_ASSOC)['total_customers'];
        
        // Tour có doanh thu cao nhất
        $sql = "SELECT 
                    t.ten as tour_name,
                    SUM(dh.tongTien) as revenue
                FROM don_hang dh
                JOIN tour t ON dh.tour_id = t.id
                WHERE dh.trangThai = 'Đã hoàn thành'";
        
        if ($fromDate) $sql .= " AND DATE(dh.tgDatDon) >= :fromDate";
        if ($toDate) $sql .= " AND DATE(dh.tgDatDon) <= :toDate";
        
        $sql .= " GROUP BY t.id, t.ten
                  ORDER BY revenue DESC
                  LIMIT 1";
        
        $stmt = $this->conn->prepare($sql);
        if ($fromDate) $stmt->bindParam(':fromDate', $fromDate);
        if ($toDate) $stmt->bindParam(':toDate', $toDate);
        $stmt->execute();
        
        $topTour = $stmt->fetch(PDO::FETCH_ASSOC);
        $kpi['top_tour'] = $topTour ? $topTour['tour_name'] : 'N/A';
        $kpi['top_tour_revenue'] = $topTour ? $topTour['revenue'] : 0;
        
        return $kpi;
    }

    /**
     * Thống kê theo danh mục tour
     */
    public function getTourCategoryStats($fromDate = null, $toDate = null) {
        $sql = "SELECT 
                    td.ten as category_name,
                    td.id as category_id,
                    COUNT(DISTINCT t.id) as total_tours,
                    COUNT(DISTINCT CASE WHEN dh.trangThai = 'Đã hoàn thành' THEN dh.id END) as total_bookings,
                    COALESCE(SUM(CASE WHEN dh.trangThai = 'Đã hoàn thành' THEN dh.tongTien ELSE 0 END), 0) as revenue,
                    COUNT(DISTINCT CASE WHEN dh.trangThai = 'Đã hoàn thành' THEN dhkh.khachHang_id END) as total_customers
                FROM tour_danh_muc td
                LEFT JOIN tour t ON td.id = t.danhMuc_id
                LEFT JOIN don_hang dh ON t.id = dh.tour_id
                LEFT JOIN don_hang_khach_hang dhkh ON dh.id = dhkh.donHang_id";
        
        if ($fromDate || $toDate) {
            $sql .= " AND (1=1";
            if ($fromDate) $sql .= " AND DATE(dh.tgDatDon) >= :fromDate";
            if ($toDate) $sql .= " AND DATE(dh.tgDatDon) <= :toDate";
            $sql .= ")";
        }
        
        $sql .= " GROUP BY td.id, td.ten
                  ORDER BY revenue DESC";
        
        $stmt = $this->conn->prepare($sql);
        if ($fromDate) $stmt->bindParam(':fromDate', $fromDate);
        if ($toDate) $stmt->bindParam(':toDate', $toDate);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Thống kê booking theo trạng thái
     */
    public function getBookingStatusStats($fromDate = null, $toDate = null) {
        $sql = "SELECT 
                    trangThai as status,
                    COUNT(*) as count,
                    SUM(tongTien) as total_amount,
                    COUNT(DISTINCT dhkh.khachHang_id) as total_customers
                FROM don_hang dh
                LEFT JOIN don_hang_khach_hang dhkh ON dh.id = dhkh.donHang_id
                WHERE 1=1";
        
        if ($fromDate) $sql .= " AND DATE(dh.tgDatDon) >= :fromDate";
        if ($toDate) $sql .= " AND DATE(dh.tgDatDon) <= :toDate";
        
        $sql .= " GROUP BY trangThai";
        
        $stmt = $this->conn->prepare($sql);
        if ($fromDate) $stmt->bindParam(':fromDate', $fromDate);
        if ($toDate) $stmt->bindParam(':toDate', $toDate);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * So sánh hiệu quả các tour theo tháng (3 tháng gần nhất)
     */
    public function compareToursByMonth($months = 3) {
        $sql = "SELECT 
                    t.ten as tour_name,
                    DATE_FORMAT(dh.tgDatDon, '%Y-%m') as month,
                    SUM(dh.tongTien) as revenue,
                    COUNT(DISTINCT dh.id) as bookings
                FROM don_hang dh
                JOIN tour t ON dh.tour_id = t.id
                WHERE dh.trangThai = 'Đã hoàn thành'
                    AND dh.tgDatDon >= DATE_SUB(CURDATE(), INTERVAL :months MONTH)
                GROUP BY t.id, t.ten, DATE_FORMAT(dh.tgDatDon, '%Y-%m')
                ORDER BY month DESC, revenue DESC";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':months', $months, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Tính tỷ lệ chuyển đổi booking (Conversion Rate)
     * Dựa trên trạng thái: 'Chờ duyệt' = Lead, 'Đã hoàn thành' = Converted
     */
    public function getConversionRate($fromDate = null, $toDate = null) {
        $sql = "SELECT 
                    COUNT(*) as total_bookings,
                    SUM(CASE WHEN trangThai = 'Đã hoàn thành' THEN 1 ELSE 0 END) as successful_bookings,
                    SUM(CASE WHEN trangThai = 'Chờ duyệt' THEN 1 ELSE 0 END) as pending_bookings,
                    ROUND((SUM(CASE WHEN trangThai = 'Đã hoàn thành' THEN 1 ELSE 0 END) / COUNT(*) * 100), 2) as conversion_rate
                FROM don_hang
                WHERE 1=1";
        
        if ($fromDate) $sql .= " AND DATE(tgDatDon) >= :fromDate";
        if ($toDate) $sql .= " AND DATE(tgDatDon) <= :toDate";
        
        $stmt = $this->conn->prepare($sql);
        if ($fromDate) $stmt->bindParam(':fromDate', $fromDate);
        if ($toDate) $stmt->bindParam(':toDate', $toDate);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Tỷ lệ chuyển đổi theo tour
     */
    public function getConversionRateByTour($fromDate = null, $toDate = null) {
        $sql = "SELECT 
                    t.id,
                    t.ten as tour_name,
                    td.ten as category_name,
                    COUNT(dh.id) as total_bookings,
                    SUM(CASE WHEN dh.trangThai = 'Đã hoàn thành' THEN 1 ELSE 0 END) as successful_bookings,
                    SUM(CASE WHEN dh.trangThai = 'Chờ duyệt' THEN 1 ELSE 0 END) as pending_bookings,
                    ROUND((SUM(CASE WHEN dh.trangThai = 'Đã hoàn thành' THEN 1 ELSE 0 END) / COUNT(dh.id) * 100), 2) as conversion_rate
                FROM tour t
                LEFT JOIN tour_danh_muc td ON t.danhMuc_id = td.id
                LEFT JOIN don_hang dh ON t.id = dh.tour_id";
        
        if ($fromDate || $toDate) {
            $sql .= " WHERE 1=1";
            if ($fromDate) $sql .= " AND DATE(dh.tgDatDon) >= :fromDate";
            if ($toDate) $sql .= " AND DATE(dh.tgDatDon) <= :toDate";
        }
        
        $sql .= " GROUP BY t.id, t.ten, td.ten
                  HAVING total_bookings > 0
                  ORDER BY conversion_rate DESC";
        
        $stmt = $this->conn->prepare($sql);
        if ($fromDate) $stmt->bindParam(':fromDate', $fromDate);
        if ($toDate) $stmt->bindParam(':toDate', $toDate);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Tỷ lệ chuyển đổi theo HDV
     */
    public function getConversionRateByHDV($fromDate = null, $toDate = null) {
        $sql = "SELECT 
                    h.id,
                    h.hoTen as hdv_name,
                    COUNT(dh.id) as total_bookings,
                    SUM(CASE WHEN dh.trangThai = 'Đã hoàn thành' THEN 1 ELSE 0 END) as successful_bookings,
                    SUM(CASE WHEN dh.trangThai = 'Chờ duyệt' THEN 1 ELSE 0 END) as pending_bookings,
                    ROUND((SUM(CASE WHEN dh.trangThai = 'Đã hoàn thành' THEN 1 ELSE 0 END) / COUNT(dh.id) * 100), 2) as conversion_rate,
                    SUM(CASE WHEN dh.trangThai = 'Đã hoàn thành' THEN dh.tongTien ELSE 0 END) as total_revenue
                FROM hdv h
                LEFT JOIN don_hang dh ON h.id = dh.hdv_id";
        
        if ($fromDate || $toDate) {
            $sql .= " WHERE 1=1";
            if ($fromDate) $sql .= " AND DATE(dh.tgDatDon) >= :fromDate";
            if ($toDate) $sql .= " AND DATE(dh.tgDatDon) <= :toDate";
        }
        
        $sql .= " GROUP BY h.id, h.hoTen
                  HAVING total_bookings > 0
                  ORDER BY conversion_rate DESC, total_revenue DESC";
        
        $stmt = $this->conn->prepare($sql);
        if ($fromDate) $stmt->bindParam(':fromDate', $fromDate);
        if ($toDate) $stmt->bindParam(':toDate', $toDate);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
