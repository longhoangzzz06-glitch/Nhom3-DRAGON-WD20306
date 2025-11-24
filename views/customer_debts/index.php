<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="container mt-4">
    <h2 class="mb-4">Công Nợ Khách Hàng</h2>

    <a href="/customerDebts/create" class="btn btn-primary mb-3">+ Thêm công nợ</a>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Tên Khách Hàng</th>
            <th>Tên Tour</th>
            <th>Công Nợ</th>
            <th>Đã Thanh Toán</th>
            <th>Còn Lại</th>
            <th>Ngày Cập Nhật</th>
            <th>Hành Động</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($debts as $d): ?>
            <tr>
                <td><?= $d['id'] ?></td>
                <td><?= $d['customer_name'] ?></td>
                <td><?= $d['tour_name'] ?></td>
                <td><?= number_format($d['total_debt']) ?> đ</td>
                <td><?= number_format($d['paid_amount']) ?> đ</td>
                <td><?= number_format($d['remaining']) ?> đ</td>
                <td><?= $d['updated_at'] ?></td>
                <td>
                    <a href="/customerDebts/edit/<?= $d['id'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                    <a onclick="return confirm('Xóa công nợ này?')"
                       href="/customerDebts/delete/<?= $d['id'] ?>" class="btn btn-danger btn-sm">
                        Xóa
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>