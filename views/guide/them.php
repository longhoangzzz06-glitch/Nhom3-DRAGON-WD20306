<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded-xl shadow-lg">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Thêm Hướng Dẫn Viên</h2>

    <form action="?act=hdv-luu" method="POST" class="space-y-4">

        <div>
            <label class="block font-medium">Họ tên</label>
            <input type="text" name="name"
                   class="w-full p-2 border rounded focus:ring focus:ring-blue-300" required>
        </div>

        <div>
            <label class="block font-medium">Email (tài khoản)</label>
            <input type="email" name="email"
                   class="w-full p-2 border rounded focus:ring focus:ring-blue-300" required>
        </div>

        <div>
            <label class="block font-medium">Số điện thoại</label>
            <input type="text" name="phone"
                   class="w-full p-2 border rounded focus:ring focus:ring-blue-300" required>
        </div>

        <button class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
            Tạo HDV
        </button>
    </form>
</div>

</body>
</html>