<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <!-- views/debts/customers.php -->
<div class="container mt-4">
    <h2 class="mb-4">Quản lý công nợ khách hàng</h2>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Tên khách hàng</th>
                <th>Tổng số đơn</th>
                <th>Tổng công nợ</th>
                <th>Đã thanh toán</th>
                <th>Còn lại</th>
                <th>Cập nhật lúc</th>
                <th width="140">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; foreach ($customerDebts as $row): ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= $row['customer_name'] ?></td>
                <td><?= $row['total_orders'] ?></td>
                <td><?= number_format($row['total_debt']) ?>đ</td>
                <td><?= number_format($row['total_paid']) ?>đ</td>
                <td class="text-danger fw-bold"><?= number_format($row['remaining']) ?>đ</td>
                <td><?= $row['updated_at'] ?></td>
                <td>
                    <a href="index.php?controller=debt&action=detail&type=customer&id=<?= $row['customer_id'] ?>"
                       class="btn btn-primary btn-sm">Xem</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
