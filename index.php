<?php
// index.php
ob_start();

// Bắt đầu session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ----------------------------------------------------------------------
// 1. KIỂM TRA TRẠNG THÁI ĐĂNG NHẬP
// ----------------------------------------------------------------------

if (!isset($_SESSION['chucVu'])) {
    // Nếu chưa đăng nhập, chuyển hướng đến trang đăng nhập
    header('Location: ./views/dangNhap/dangNhap.php'); 
    exit();
}

// Nếu đã đăng nhập, lấy chức vụ
$chucVu = $_SESSION['chucVu'];

// ----------------------------------------------------------------------
// 2. PHÂN QUYỀN VÀ HIỂN THỊ NỘI DUNG
// ----------------------------------------------------------------------

if ($chucVu === 'admin') {
    // Nếu là admin, hiển thị giao diện AdminLTE (từ file admin.php)
    require_once "./views/chung/admin.php";

} elseif ($chucVu === 'hdv') {
    // Nếu là hdv, hiển thị giao diện Hướng dẫn viên (từ file hdv.php)
    // Lưu ý: Tệp hdv.php phải được tạo
    require_once "./views/chung/hdv.php"; 

} else {
    // Xử lý các trường hợp chức vụ không xác định
    echo "Lỗi truy cập: Chức vụ **$chucVu** không được hỗ trợ.";
    echo '<p><a href="./views/dangNhap/logout.php">Đăng Xuất</a></p>';
}

ob_end_flush();
?>