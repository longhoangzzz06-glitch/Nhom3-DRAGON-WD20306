<?php 
// Route
$act = $_GET['act'] ?? '/';

match ($act) {
    // Trang chủ
    '/', 'trang-chu' => (new HDVController())->danhSach(),
    
    /* Trang quản lý hướng dẫn viên */
    // Hiển thị danh sách hướng dẫn viên
    'quan-ly-hdv'=> (new HDVController())->danhSach(),
    'lay-don-hang-khach-hang' => (new HDVController())->getDonHangKhachHang($_GET['don_hang_id']),
    // Xử lý thêm hướng dẫn viên
    'view-them-hdv'=> (new HDVController())->viewThemHDV(),
    'them-hdv'=> (new HDVController())->themHDV($_POST),
    // Xử lý xóa hướng dẫn viên
    'xoa-hdv'=> (new HDVController())->xoaHDV($_GET['id']),
    // Xử lý cập nhật hướng dẫn viên
    'view-cap-nhat-hdv'=> (new HDVController())->viewCapNhatHDV($_GET['id']),
    'cap-nhat-hdv'=> (new HDVController())->capNhatHDV($_GET['id'], $_POST),

    /* Trang quản lý Tours */
    // Hiển thị danh sách Tours
    'quan-ly-tours'=> (new TourController())->danhSachTour(),
    // Xử lý thêm Tours
    'view-them-tour'=> (new TourController())->viewThemTour(),
    'them-tour'=> (new TourController())->themTour($_POST), 
    // Xử lý xóa Tours
    'xoa-tour'=> (new TourController())->xoaTour($_GET['id']),
    // Xử lý cập nhật Tours
    'view-cap-nhat-tour'=> (new TourController())->viewCapNhatTour($_GET['id']),
    'cap-nhat-tour'=> (new TourController())->capNhatTour($_GET['id'], $_POST),

    /* Trang quản lý Booking */
    // Hiển thị danh sách Booking
    'quan-ly-booking'=> (new BookingController())->danhSachBooking(),
    // Xử lý xóa Booking
    'xoa-booking'=> (new BookingController())->delete(),
    // Xử lý cập nhật Booking
    'view-cap-nhat-booking'=> (new BookingController())->edit($_GET['id'] ?? null),
    'cap-nhat-booking'=> (new BookingController())->update($_GET['id'] ?? null, $_POST),
    // Xử lý đặt booking
    'view-dat-booking'=> (new BookingController())->viewDatBooking(),
    'dat-booking'=> (new BookingController())->datBooking($_POST),
    // API Check-in
    'api-check-in'=> (new BookingController())->apiCheckIn(),
    'api-get-customers'=> (new BookingController())->apiGetCustomersList(),
    // API Add/Delete Customer
    'api-add-customer'=> (new BookingController())->apiAddCustomer(),
    'api-add-customer-link'=> (new BookingController())->apiAddCustomerLink(),
    'api-delete-customer'=> (new BookingController())->apiDeleteCustomer(),

    /* Trang Báo cáo Vận hành */
    // Hiển thị báo cáo
    'bao-cao-van-hanh'=> (new ReportController())->index(),
    // Xuất báo cáo Excel
    'bao-cao-export'=> (new ReportController())->export(),

    /* Trang HDV */
    // Lịch làm việc của HDV - Controller
    'hdv-lich-lam-viec'=> (new HDVController())->lichLamViec($_SESSION['hdv_id'] ?? 5),
    // Chi tiết tour (lịch trình + danh sách khách) - TourDetailController
    'hdv-chi-tiet-tour'=> (new TourDetailController())->chiTietTour($_GET['id'] ?? 0),
    // Nhật ký tour - TourDetailController
    'hdv-nhat-ky-tour'=> (new TourDetailController())->taoNhatKyTour($_GET['id'] ?? 0),
    // Điểm danh khách hàng - Controller
    'hdv-diem-danh'=> (new HDVController())->diemDanhKhach($_GET['id'] ?? 0),
    // Yêu cầu đặc biệt từ khách hàng - Controller
    'hdv-yeu-cau-dac-biet'=> (new HDVController())->yeuCauDacBiet($_GET['id'] ?? 0),
    // Đánh giá tour - Controller
    'hdv-danh-gia-tour'=> (new HDVController())->danhGiaTour($_GET['id'] ?? 0),

    /* Trang quản lý Địa điểm */
    // Hiển thị danh sách Địa điểm
    'quan-ly-dia-diem'=> (new DiaDiemController())->danhSachDiaDiem(),
    // Xử lý thêm Địa điểm
    'view-them-dia-diem'=> (new DiaDiemController())->viewThemDiaDiem(),
    'them-dia-diem'=> (new DiaDiemController())->themDiaDiem($_POST),
    // Xử lý xóa Địa điểm
    'xoa-dia-diem'=> (new DiaDiemController())->xoaDiaDiem($_GET['id']),
    // Xử lý cập nhật Địa điểm
    'view-cap-nhat-dia-diem'=> (new DiaDiemController())->viewCapNhatDiaDiem($_GET['id']),
    'cap-nhat-dia-diem'=> (new DiaDiemController())->capNhatDiaDiem($_GET['id'], $_POST),

    'them-ncc-vao-tour' => (new NCCController())->themNccVaoTour($_GET['tour_id'], $_GET['ncc_id']),
    'xoaNccKhoiTour' => (new NCCController())->xoaNccKhoiTour($_GET['tour_id'], $_GET['ncc_id']),
};

?>
<script> 
    const routeToMenuMap = {
    'quan-ly-hdv': 'nav-hdv',
    'view-them-hdv': 'nav-hdv',
    'them-hdv': 'nav-hdv',
    'xoa-hdv': 'nav-hdv',
    'view-cap-nhat-hdv': 'nav-hdv',
    'cap-nhat-hdv': 'nav-hdv',
    
    'quan-ly-tours': 'nav-tour',
    'view-them-tour': 'nav-tour',
    'them-tour': 'nav-tour',
    'xoa-tour': 'nav-tour',
    'view-cap-nhat-tour': 'nav-tour',
    'cap-nhat-tour': 'nav-tour',
    
    'quan-ly-booking': 'nav-booking',
    'xoa-booking': 'nav-booking',
    'view-cap-nhat-booking': 'nav-booking',
    'cap-nhat-booking': 'nav-booking',
    'view-dat-booking': 'nav-booking',
    'dat-booking': 'nav-booking',

    'bao-cao-van-hanh': 'nav-report',
    'bao-cao-export': 'nav-report',

    'hdv-lich-lam-viec': 'nav-hdv-work',
    'hdv-chi-tiet-tour': 'nav-hdv-work',
    'hdv-nhat-ky-tour': 'nav-hdv-work',
    'hdv-diem-danh': 'nav-hdv-work',
    'hdv-yeu-cau-dac-biet': 'nav-hdv-work',
    'hdv-danh-gia-tour': 'nav-hdv-work',

    'quan-ly-dia-diem': 'nav-diadiem',
    'view-them-dia-diem': 'nav-diadiem',
    'them-dia-diem': 'nav-diadiem',
    'xoa-dia-diem': 'nav-diadiem',
    'view-cap-nhat-dia-diem': 'nav-diadiem',
    'cap-nhat-dia-diem': 'nav-diadiem',
    };
</script>