<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded-xl shadow-lg">
    <h2 class="text-2xl font-bold text-green-600 mb-4">Reset mật khẩu thành công!</h2>

    <p class="text-gray-700">Mật khẩu mới của HDV là:</p>

    <div class="mt-4 p-3 bg-gray-100 text-red-600 font-bold text-xl rounded border border-gray-300">
        <?= $matKhauMoi ?>
    </div>

    <p class="mt-4 text-gray-600">Hãy gửi mật khẩu này cho HDV để họ đăng nhập lại.</p>

    <a href="?act=guide-list" 
       class="inline-block mt-6 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
       Quay lại danh sách HDV
    </a>
</div>

</body>
</html>