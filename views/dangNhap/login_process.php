<?php
// Bắt đầu session và đảm bảo không có output nào trước đó
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Nhúng các file cần thiết (đường dẫn đã được sửa)
require_once '../../commons/env.php';
require_once '../../commons/function.php';

// Dùng header() thay vì echo script
function redirect($url) {
    header("Location: " . $url);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tenTk = trim($_POST['tenTk'] ?? '');
    $mk = $_POST['mk'] ?? '';

    if (empty($tenTk) || empty($mk)) {
        $_SESSION['login_error'] = "Vui lòng nhập đầy đủ Tên tài khoản và Mật khẩu.";
        redirect("dangNhap.php");
    }

    try {
        $conn = connectDB();
        
        // 1. TRUY VẤN SQL CƠ BẢN (CHỈ LẤY THÔNG TIN CẦN THIẾT TỪ TAI_KHOAN)
        // Dùng dấu nháy đơn cho truy vấn để tránh lỗi chuỗi (best practice)
        $sql = '
            SELECT 
                tk.id AS taiKhoan_id, 
                tk.tenTk, 
                tk.mk,
                hdv.id AS hdv_id, 
                tk.chucVu
            FROM 
                tai_khoan tk
            LEFT JOIN hdv ON hdv.taiKhoan_id = tk.id
            WHERE 
                tk.tenTk = :tenTk
        ';
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':tenTk', $tenTk);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // 2. XÁC THỰC MẬT KHẨU
        if ($user && password_verify($mk, $user['mk'])) {
            
            // Đăng nhập thành công!
            
            // 3. LƯU THÔNG TIN VÀO SESSION
            $_SESSION['loggedin'] = true;
            $_SESSION['tenTk'] = $user['tenTk'];
            $_SESSION['chucVu'] = $user['chucVu'];
            $_SESSION['taiKhoan_id'] = $user['taiKhoan_id']; // ID để lấy thông tin chi tiết sau
            $_SESSION['hdv_id'] = $user['hdv_id'];
            
            // BỎ HẲN MỌI LOGIC LẤY HDV_ID Ở ĐÂY!
            // Đưa toàn bộ logic phân biệt HDV/Admin sang index.php và hdv.php

            // Xóa lỗi và chuyển hướng về trang chủ
            unset($_SESSION['login_error']);
            redirect("../../index.php");

        } else {
            // Đăng nhập thất bại
            $_SESSION['login_error'] = "Tên tài khoản hoặc mật khẩu không đúng.";
            redirect("dangNhap.php");
        }

    } catch(PDOException $e) {
        // Lỗi hệ thống hoặc kết nối database
        $_SESSION['login_error'] = "Lỗi hệ thống: Không thể xử lý yêu cầu đăng nhập.";
        error_log("Login DB Error: " . $e->getMessage()); 
        redirect("dangNhap.php");
    }
} else {
    redirect("dangNhap.php");
}
?>