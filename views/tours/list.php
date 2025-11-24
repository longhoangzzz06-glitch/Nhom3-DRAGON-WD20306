<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <h1 class="title">Danh sách Tour</h1>


<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên tour</th>
            <th>Giá</th>
            <th>Ngày khởi hành</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tours as $item): ?>
        <tr>
            <td><?= $item['id'] ?></td>
            <td><?= $item['name'] ?></td>
            <td><?= number_format($item['price']) ?>đ</td>
            <td><?= $item['start_date'] ?></td>
            <td>
                <a class="btn btn-warning" href="index.php?controller=tours&action=edit&id=<?= $item['id'] ?>">Sửa</a>
                <a class="btn btn-danger" href="index.php?controller=tours&action=delete&id=<?= $item['id'] ?>">Xóa</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>