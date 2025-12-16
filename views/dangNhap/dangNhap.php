<?php
// Bắt đầu session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kiểm tra nếu người dùng đã đăng nhập, chuyển hướng về trang chủ
if (isset($_SESSION['chucVu'])) {
    header('Location: ../../index.php');
    exit();
}

// Lấy thông báo lỗi
$error_message = isset($_SESSION['login_error']) ? $_SESSION['login_error'] : '';
unset($_SESSION['login_error']); // Xóa lỗi sau khi hiển thị
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng Nhập Hệ Thống</title>
    <style>
        /* CSS cơ bản */
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-container { background: white; padding: 25px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); width: 300px; }
        h2 { text-align: center; color: #333; margin-bottom: 20px;}
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="password"] { width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        input[type="submit"] { background-color: #007bff; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; width: 100%; font-size: 16px; }
        input[type="submit"]:hover { background-color: #0056b3; }
        .error { color: red; text-align: center; margin-bottom: 15px; font-weight: bold; border: 1px solid #ffcccc; background-color: #fff0f0; padding: 10px; border-radius: 4px;}
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Đăng Nhập</h2>
        
        <?php if (!empty($error_message)): ?>
            <p class="error"><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>

        <form action="login_process.php" method="POST">
            <label for="tenTk">Tên tài khoản:</label>
            <input type="text" id="tenTk" name="tenTk" required>

            <label for="mk">Mật khẩu:</label>
            <input type="password" id="mk" name="mk" required>

            <input type="submit" value="Đăng Nhập">
        </form>
    </div>
</body>
</html>