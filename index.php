<?php 
// Require toàn bộ các file khai báo môi trường, thực thi,...(không require view)

// Require file Common
require_once './commons/env.php'; // Khai báo biến môi trường
require_once './commons/function.php'; // Hàm hỗ trợ

// Require toàn bộ file Controllers
require_once './controllers/HDVController.php';
require_once './controllers/TourController.php';
require_once './controllers/BookingController.php';

// Require toàn bộ file Models
require_once './models/HDVModel.php';
require_once './models/TourModel.php';
require_once './models/BookingModel.php';

// Route
$act = $_GET['act'] ?? '/';

// Để bảo bảo tính chất chỉ gọi 1 hàm Controller để xử lý request thì mình sử dụng match


match ($act) {
    // Trang chủ
    '/', 'trang-chu' => (new HDVController())->danhSach(),
    
    /* Trang quản lý hướng dẫn viên */
    // Hiển thị danh sách hướng dẫn viên
    'quan-ly-hdv'=> (new HDVController())->danhSach(),
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
};
