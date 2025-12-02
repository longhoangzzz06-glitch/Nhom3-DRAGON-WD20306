<?php
require_once './models/TourDetailModel.php';
require_once './models/ReviewModel.php';

class TourDetailController
{
    private $modelTourDetail;
    private $modelReview;

    public function __construct()
    {
        $this->modelTourDetail = new TourDetailModel();
        $this->modelReview = new ReviewModel();
    }

    // Chi tiết tour (lịch trình + khách hàng)
    public function chiTietTour($tourId)
    {
        try {
            // Lấy thông tin tour
            $tour = $this->modelTourDetail->getTourInfo($tourId);
            $tour_id = $tourId;
            
            if (!$tour) {
                echo "<script>alert('Không tìm thấy tour!'); window.location.href='?act=hdv-lich-lam-viec';</script>";
                exit();
            }
            
            // Lấy danh sách khách hàng
            $rawCustomers = $this->modelTourDetail->getCustomersByTour($tourId);
            
            // Format customers for view
            $customers = [];
            foreach ($rawCustomers as $c) {
                $customers[] = [
                    'ten' => $c['khachHang_ten'],
                    'tuoi' => $c['tuoi'],
                    'gioiTinh' => $c['gioiTinh'],
                    'dienThoai' => $c['dienThoai'],
                    'email' => $c['email'],
                    'soPhong' => $c['soPhong'] ?? '',
                    'ghiChu' => $c['ghiChuDB'] ?? '',
                    'checkin' => ($c['trangThai_checkin'] ?? 'pending') === 'present'
                ];
            }
            
            // Lấy lịch trình tour
            $rawItinerary = $this->modelTourDetail->getItineraryByTour($tourId);
            
            // Format itinerary for view (already has correct aliases from model)
            $itinerary = [];
            foreach ($rawItinerary as $item) {
                $itinerary[] = [
                    'day' => $item['day'],
                    'title' => $item['title'],
                    'activities' => $item['activities'] ?? 'Chi tiết lịch trình sẽ được cập nhật'
                ];
            }
            
            // If no itinerary from DB, create mock one
            if (empty($itinerary)) {
                $itinerary = [
                    ['day' => 1, 'title' => 'Khởi hành', 'activities' => 'Lịch trình chi tiết sẽ được cập nhật']
                ];
            }
            
            // Include view
            include './views/HDV/chi_tiet_tour.php';
        } catch (Exception $e) {
            echo "<script>alert('Lỗi: " . addslashes($e->getMessage()) . "'); window.history.back();</script>";
            exit();
        }
    }

    // Nhật ký tour
    public function nhatKyTour($tourId)
    {
        try {
            // Lấy thông tin tour
            $tour = $this->modelTourDetail->getTourInfo($tourId);
            $tour_id = $tourId;
            
            if (!$tour) {
                echo "<script>alert('Không tìm thấy tour!'); window.location.href='?act=hdv-lich-lam-viec';</script>";
                exit();
            }
            
            // Lấy danh sách nhật ký
            $rawDiaries = $this->modelReview->getDiaryEntries($tourId);
            
            // Format diary entries for view
            $diaryEntries = [];
            foreach ($rawDiaries as $entry) {
                $diaryEntries[] = [
                    'id' => $entry['id'],
                    'date' => $entry['ngayTao'] ?? date('Y-m-d'),
                    'time' => date('H:i d/m/Y', strtotime($entry['ngayTao'] ?? 'now')),
                    'title' => $entry['tieuDe'],
                    'content' => $entry['noiDung'],
                    'incident' => ($entry['loai'] === 'incident' || $entry['loai'] === 'issue') ? $entry['noiDung'] : '',
                    'feedback' => '',
                    'type' => ucfirst($entry['loai'] ?? 'event'),
                    'images' => !empty($entry['anhMinhHoa']) ? explode(',', $entry['anhMinhHoa']) : []
                ];
            }
            
            // Include view
            include './views/HDV/nhat_ky_tour.php';
        } catch (Exception $e) {
            echo "<script>alert('Lỗi: " . addslashes($e->getMessage()) . "'); window.history.back();</script>";
            exit();
        }
    }
}
