<?php 
// Require toàn bộ các file khai báo môi trường, thực thi,...(không require view)

// Require file Common
require_once './commons/env.php'; // Khai báo biến môi trường
require_once './commons/function.php'; // Hàm hỗ trợ

// Require toàn bộ file Controllers
require_once './controllers/HDVController.php';

// Require toàn bộ file Models
require_once './models/HDVModel.php';

// Route
$act = $_GET['act'] ?? '/';


// Để bảo bảo tính chất chỉ gọi 1 hàm Controller để xử lý request thì mình sử dụng match

match ($act) {
    // Trang chủ
    'home' => (new HomeController())->home(),
    // Trang quản lý hướng dẫn viên
    // Hiển thị danh sách hướng dẫn viên
    '/'=> (new HDVController())->DanhSach(),
    // Xử lý thêm hướng dẫn viên
    'view-them-hdv'=> (new HDVController())->viewThemHDV(),
    'them-hdv'=> (new HDVController())->addHDV($_POST),
    // Xử lý xóa hướng dẫn viên
    'xoa-hdv'=> (new HDVController())->deleteHDV($_GET['id']),
    // Xử lý cập nhật hướng dẫn viên
    'view-cap-nhat-hdv'=> (new HDVController())->viewCapNhatHDV($_GET['id']),
    'cap-nhat-hdv'=> (new HDVController())->editHDV($_GET['id'], $_POST),
};