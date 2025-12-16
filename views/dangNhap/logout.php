<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Hủy bỏ tất cả các biến session
$_SESSION = array();

// Hủy session
session_destroy();

// Chuyển hướng về trang đăng nhập
header("Location: ../../views/dangNhap/dangNhap.php");
exit();
?>