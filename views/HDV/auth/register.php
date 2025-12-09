<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="max-w-md mx-auto mt-20 shadow-lg p-8 rounded-xl bg-white">
    <h2 class="text-2xl font-bold mb-6 text-center">Đăng ký HDV</h2>

    <form action="index.php?act=hdv_register_post" method="POST" class="space-y-4">
        <input type="text" name="name" class="w-full border p-3 rounded"
               placeholder="Họ và tên" required>

        <input type="email" name="email" class="w-full border p-3 rounded"
               placeholder="Email" required>

        <input type="password" name="password" class="w-full border p-3 rounded"
               placeholder="Mật khẩu" required>

        <button class="w-full bg-green-600 text-white py-3 rounded hover:bg-green-700">
            Đăng ký
        </button>
    </form>

    <p class="text-center mt-4">
        Đã có tài khoản?
        <a href="index.php?act=login" class="text-blue-600">Đăng nhập</a>
    </p>
</div>

</body>
</html>