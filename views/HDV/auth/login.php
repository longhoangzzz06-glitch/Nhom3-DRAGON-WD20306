<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="max-w-md mx-auto mt-20 shadow-lg p-8 rounded-xl bg-white">
    <h2 class="text-2xl font-bold mb-6 text-center">Đăng nhập HDV</h2>

    <form action="index.php?act=hdv_login_post" method="POST" class="space-y-4">
        <input type="email" name="email" class="w-full border p-3 rounded"
               placeholder="Email" required>

        <input type="password" name="password" class="w-full border p-3 rounded"
               placeholder="Mật khẩu" required>

        <button class="w-full bg-blue-600 text-white py-3 rounded hover:bg-blue-700">
            Đăng nhập
        </button>
    </form>

    <p class="text-center mt-4">
        Chưa có tài khoản? 
        <a href="index.php?act=register" class="text-blue-600">Đăng ký</a>
    </p>
</div>

</body>
</html>

