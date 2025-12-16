<?php 
// Route
$act = $_GET['act'] ?? '/';

match ($act) {
    // Trang chủ
    
    '/', 'trang-chu' => (new HDVController())->trangChu(),
    
    /* Trang quản lý hướng dẫn viên */
    'quan-ly-hdv'=> (new HDVController())->danhSach(),
    'lay-don-hang-khach-hang' => (new HDVController())->getDonHangKhachHang($_GET['don_hang_id']),
    'view-them-hdv'=> (new HDVController())->viewThemHDV(),
    'them-hdv'=> (new HDVController())->themHDV($_POST),
    'xoa-hdv'=> (new HDVController())->xoaHDV($_GET['id']),
    'view-cap-nhat-hdv'=> (new HDVController())->viewCapNhatHDV($_GET['id']),
    'cap-nhat-hdv'=> (new HDVController())->capNhatHDV($_GET['id'], $_POST),

    /* Trang quản lý Tours */
    'quan-ly-tours'=> (new TourController())->danhSachTour(),
    'view-them-tour'=> (new TourController())->viewThemTour(),
    'them-tour'=> (new TourController())->themTour($_POST), 
    'xoa-tour'=> (new TourController())->xoaTour($_GET['id']),
    'view-cap-nhat-tour'=> (new TourController())->viewCapNhatTour($_GET['id']),
    'cap-nhat-tour'=> (new TourController())->capNhatTour($_GET['id'], $_POST),

    /* Trang quản lý Booking */
    'quan-ly-booking'=> (new BookingController())->danhSachBooking(),
    'xoa-booking'=> (new BookingController())->delete(),
    'view-cap-nhat-booking'=> (new BookingController())->edit($_GET['id'] ?? null),
    'cap-nhat-booking'=> (new BookingController())->update($_GET['id'] ?? null, $_POST),
    'view-dat-booking'=> (new BookingController())->viewDatBooking(),
    'dat-booking'=> (new BookingController())->datBooking($_POST),

    /* Trang Báo cáo Vận hành */
    'bao-cao-van-hanh'=> (new ReportController())->index(),
    'bao-cao-export'=> (new ReportController())->export(),

    /* Trang HDV */
    'hdv-lich-lam-viec'=> (new HDVController())->lichLamViec($_SESSION['hdv_id'] ?? 0),
    'hdv-chi-tiet-tour'=> (new TourDetailController())->chiTietTour($_GET['id'] ?? 0),
    'hdv-nhat-ky-tour'=> (new TourDetailController())->taoNhatKyTour($_GET['id'] ?? 0),
    'hdv-diem-danh'=> (new HDVController())->diemDanhKhach($_GET['id'] ?? 0),
    'hdv-yeu-cau-dac-biet'=> (new HDVController())->yeuCauDacBiet($_GET['id'] ?? 0),
    'hdv-danh-gia-tour'=> (new HDVController())->danhGiaTour($_GET['id'] ?? 0),

    /* Trang quản lý Địa điểm */
    'quan-ly-dia-diem'=> (new DiaDiemController())->danhSachDiaDiem(),
    'view-them-dia-diem'=> (new DiaDiemController())->viewThemDiaDiem(),
    'them-dia-diem'=> (new DiaDiemController())->themDiaDiem($_POST),
    'xoa-dia-diem'=> (new DiaDiemController())->xoaDiaDiem($_GET['id']),
    'view-cap-nhat-dia-diem'=> (new DiaDiemController())->viewCapNhatDiaDiem($_GET['id']),
    'cap-nhat-dia-diem'=> (new DiaDiemController())->capNhatDiaDiem($_GET['id'], $_POST),
    
    /* Trang quản lý NCC Tour */
    'them-ncc-vao-tour' => (new NCCController())->themNccVaoTour($_GET['tour_id'], $_GET['ncc_id']),
    'xoaNccKhoiTour' => (new NCCController())->xoaNccKhoiTour($_GET['tour_id'], $_GET['ncc_id']),

    /* Trang quản lý Supplier */
    // Hiển thị danh sách Supplier
    'quan-ly-supplier' => (new SupplierController())->index(),

    // Trang thêm Supplier
    'view-them-supplier' => (new SupplierController())->create(),
    'them-supplier' => (new SupplierController())->store($_POST),

    // Trang cập nhật Supplier
    'view-cap-nhat-supplier' => (new SupplierController())->edit($_GET['id']),
    'cap-nhat-supplier' => (new SupplierController())->update($_GET['id'], $_POST),

    // Xóa Supplier
    'xoa-supplier' => (new SupplierController())->delete($_GET['id']),
    /* Trang quản lý Hợp đồng */
    'quan-ly-hopdong' => (new HopDongController())->index(),
    'view-them-hopdong' => (new HopDongController())->create(),
    'them-hopdong' => (new HopDongController())->store($_POST),
    'view-cap-nhat-hopdong' => (new HopDongController())->edit($_GET['id']),
    'cap-nhat-hopdong' => (new HopDongController())->update($_GET['id'], $_POST),
    'xoa-hopdong' => (new HopDongController())->delete($_GET['id']),

    /* Trang quản lý Công nợ */
    'quan-ly-congno' => (new CongNoController())->index(),
    'view-them-congno' => (new CongNoController())->create(),
    'them-congno' => (new CongNoController())->store($_POST),
    'view-cap-nhat-congno' => (new CongNoController())->edit($_GET['id']),
    'cap-nhat-congno' => (new CongNoController())->update($_GET['id'], $_POST),
    'xoa-congno' => (new CongNoController())->delete($_GET['id']),

    /* Trang quản lý Đánh giá NCC */
    'quan-ly-danhgia' => (new DanhGiaNCCController())->index(),
    'view-them-danhgia' => (new DanhGiaNCCController())->create(),
    'them-danhgia' => (new DanhGiaNCCController())->store($_POST),
    'view-cap-nhat-danhgia' => (new DanhGiaNCCController())->edit($_GET['id']),
    'cap-nhat-danhgia' => (new DanhGiaNCCController())->update($_GET['id'], $_POST),
    'xoa-danhgia' => (new DanhGiaNCCController())->delete($_GET['id']),

    /* Trang Báo cáo Tài chính */
    'bao-cao-taichinh' => (new TaiChinhTourController())->baoCao(),

    // Giao diện đăng ký
    'register' => (new HdvAuthController())->registerForm(),
    // Xử lý đăng ký
    'post-register' => (new HdvAuthController())->register(),

    // Giao diện đăng nhập
    'login' => (new HdvAuthController())->loginForm(),

    // Đăng xuất
    'logout' => (new HdvAuthController())->logout(),
};

?>
<script> 
    // Định nghĩa ánh xạ route tới ID menu cha
    const routeToMenuMap = {
        '/': 'nav-report',
        'trang-chu': 'nav-report',
        
        // Quản lý Hướng dẫn viên
        'quan-ly-hdv': 'nav-hdv',
        'view-them-hdv': 'nav-hdv',
        'them-hdv': 'nav-hdv',
        'xoa-hdv': 'nav-hdv',
        'view-cap-nhat-hdv': 'nav-hdv',
        'cap-nhat-hdv': 'nav-hdv',
        'lay-don-hang-khach-hang': 'nav-hdv',

        // Quản lý Tour
        'quan-ly-tours': 'nav-tour',
        'view-them-tour': 'nav-tour',
        'them-tour': 'nav-tour',
        'xoa-tour': 'nav-tour',
        'view-cap-nhat-tour': 'nav-tour',
        'cap-nhat-tour': 'nav-tour',
        'them-ncc-vao-tour': 'nav-tour',
        'xoaNccKhoiTour': 'nav-tour',
        
        // Quản lý Booking
        'quan-ly-booking': 'nav-booking',
        'xoa-booking': 'nav-booking',
        'view-cap-nhat-booking': 'nav-booking',
        'cap-nhat-booking': 'nav-booking',
        'view-dat-booking': 'nav-booking',
        'dat-booking': 'nav-booking',

        // Báo cáo Vận hành
        'bao-cao-van-hanh': 'nav-report',
        'bao-cao-export': 'nav-report',

        // HDV - Lịch làm việc và chi tiết liên quan
        'hdv-lich-lam-viec': 'nav-hdv-work',
        'hdv-chi-tiet-tour': 'nav-hdv-work',
        'hdv-nhat-ky-tour': 'nav-hdv-work',
        'hdv-diem-danh': 'nav-hdv-work',
        'hdv-yeu-cau-dac-biet': 'nav-hdv-work',
        'hdv-danh-gia-tour': 'nav-hdv-work',

        // Quản lý Địa điểm
        'quan-ly-dia-diem': 'nav-diadiem',
        'view-them-dia-diem': 'nav-diadiem',
        'them-dia-diem': 'nav-diadiem',
        'xoa-dia-diem': 'nav-diadiem',
        'view-cap-nhat-dia-diem': 'nav-diadiem',
        'cap-nhat-dia-diem': 'nav-diadiem',

        'supplier': 'nav-supplier',
        'quan-ly-supplier': 'nav-supplier',
        'view-them-supplier': 'nav-supplier',
        'them-supplier': 'nav-supplier',
        'view-cap-nhat-supplier': 'nav-supplier',
        'cap-nhat-supplier': 'nav-supplier',
        'xoa-supplier': 'nav-supplier',
        'quan-ly-hopdong': 'nav-hopdong',
        'view-them-hopdong': 'nav-hopdong',
        'them-hopdong': 'nav-hopdong',
        'view-cap-nhat-hopdong': 'nav-hopdong',
        'cap-nhat-hopdong': 'nav-hopdong',
        'xoa-hopdong': 'nav-hopdong',

        'quan-ly-congno': 'nav-congno',
        'view-them-congno': 'nav-congno',
        'them-congno': 'nav-congno',
        'view-cap-nhat-congno': 'nav-congno',
        'cap-nhat-congno': 'nav-congno',
        'xoa-congno': 'nav-congno',

        'quan-ly-danhgia': 'nav-danhgia',
        'view-them-danhgia': 'nav-danhgia',
        'them-danhgia': 'nav-danhgia',
        'view-cap-nhat-danhgia': 'nav-danhgia',
        'cap-nhat-danhgia': 'nav-danhgia',
        'xoa-danhgia': 'nav-danhgia',

        'bao-cao-taichinh': 'nav-taichinh',
    };
</script>
