<?php
/**
 * ReportController - Xử lý báo cáo vận hành tour
 * 
 * Lưu ý: Chỉ báo cáo doanh thu, không có chi phí/lợi nhuận
 */

require_once './models/ReportModel.php';

class ReportController {
    public $reportModel;

    public function __construct() {
        $this->reportModel = new ReportModel();
    }

    /**
     * Hiển thị trang báo cáo vận hành với dashboard tổng quan
     */
    public function index() {
        // Lấy tham số lọc từ URL
        $fromDate = isset($_GET['from']) && !empty($_GET['from']) ? $_GET['from'] : null;
        $toDate = isset($_GET['to']) && !empty($_GET['to']) ? $_GET['to'] : null;
        
        // Lấy dữ liệu tổng hợp
        $summary = $this->reportModel->getReportSummary($fromDate, $toDate);
        $totalRevenue = $summary['total_revenue'] ?? 0;
        $totalCost = $summary['total_cost'] ?? 0;
        $totalProfit = $summary['total_profit'] ?? 0;
        $totalBookings = $summary['total_bookings'] ?? 0;
        
        // Lấy chi tiết từng tour
        $tours = $this->reportModel->getTourReports($fromDate, $toDate);
        
        // Lấy KPI Dashboard
        $dashboardKPI = $this->reportModel->getDashboardKPI($fromDate, $toDate);
        
        // Thống kê theo danh mục
        $categoryStats = $this->reportModel->getTourCategoryStats($fromDate, $toDate);
        
        // Thống kê trạng thái booking
        $bookingStatusStats = $this->reportModel->getBookingStatusStats($fromDate, $toDate);
        
        // So sánh theo tháng
        $monthlyComparison = $this->reportModel->compareToursByMonth(3);
        
        // Tỷ lệ chuyển đổi booking (Conversion Rate)
        $conversionRate = $this->reportModel->getConversionRate($fromDate, $toDate);
        $conversionByTour = $this->reportModel->getConversionRateByTour($fromDate, $toDate);
        $conversionByHDV = $this->reportModel->getConversionRateByHDV($fromDate, $toDate);
        
        // Truyền dữ liệu sang view
        require_once './views/baocao/baocao_vanhanh.php';
    }

    /**
     * Xuất báo cáo ra file CSV
     */
    public function export() {
        $fromDate = isset($_GET['from']) && !empty($_GET['from']) ? $_GET['from'] : null;
        $toDate = isset($_GET['to']) && !empty($_GET['to']) ? $_GET['to'] : null;

        $tours = $this->reportModel->getTourReports($fromDate, $toDate);

        // Set headers cho CSV download
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=baocao_vanhanh_' . date('Y-m-d') . '.csv');

        $output = fopen('php://output', 'w');
        
        // UTF-8 BOM cho Excel
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

        // Header row
        fputcsv($output, ['Mã tour', 'Tên tour', 'Danh mục', 'Doanh thu', 'Số booking', 'Tổng khách']);

        // Data rows
        foreach ($tours as $tour) {
            fputcsv($output, [
                $tour['id'],
                $tour['name'],
                $tour['category_name'] ?? 'N/A',
                number_format($tour['revenue'], 0, ',', '.'),
                $tour['bookings'],
                $tour['total_customers'] ?? 0
            ]);
        }

        fclose($output);
        exit;
    }
}
?>
