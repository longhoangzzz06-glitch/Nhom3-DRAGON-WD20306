<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="container mt-4">
    <h2 class="mb-4">Công Nợ Nhà Cung Cấp</h2>

    <a href="/supplierDebts/create" class="btn btn-primary mb-3">+ Thêm công nợ NCC</a>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Nhà Cung Cấp</th>
            <th>Loại Dịch Vụ</th>
            <th>Tổng Công Nợ</th>
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
                <td><?= $d['supplier_name'] ?></td>
                <td><?= $d['service_type'] ?></td>
                <td><?= number_format($d['total_debt']) ?> đ</td>
                <td><?= number_format($d['paid_amount']) ?> đ</td>
                <td><?= number_format($d['remaining']) ?> đ</td>
                <td><?= $d['updated_at'] ?></td>
                <td>
                    <a href="/supplierDebts/edit/<?= $d['id'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                    <a onclick="return confirm('Xóa công nợ này?')"
                       href="/supplierDebts/delete/<?= $d['id'] ?>" class="btn btn-danger btn-sm">Xóa</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>