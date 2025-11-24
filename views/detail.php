<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <!-- views/debts/detail.php -->
<div class="container mt-4">

    <h3 class="mb-3">
        <?= $type === "customer" ? "Chi tiết công nợ khách hàng" : "Chi tiết công nợ nhà cung cấp" ?>
    </h3>

    <div class="card mb-4">
        <div class="card-header bg-dark text-white">
            Thông tin cơ bản
        </div>
        <div class="card-body">
            <p><strong>Tên:</strong> <?= $info['name'] ?></p>
            <p><strong>Tổng công nợ:</strong> <?= number_format($info['total_debt']) ?>đ</p>
            <p><strong>Đã thanh toán:</strong> <?= number_format($info['total_paid']) ?>đ</p>
            <p><strong>Còn lại:</strong> 
                <span class="text-danger fw-bold"><?= number_format($info['remaining']) ?>đ</span>
            </p>
        </div>
    </div>

    <h4 class="mb-3">Lịch sử giao dịch</h4>

    <table class="table table-bordered table-hover">
        <thead class="table-secondary">
            <tr>
                <th>#</th>
                <th>Mô tả</th>
                <th>Số tiền</th>
                <th>Loại</th>
                <th>Thời gian</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; foreach ($transactions as $t): ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= $t['description'] ?></td>
                <td><?= number_format($t['amount']) ?>đ</td>
                <td>
                    <?php if ($t['type'] === 'debt'): ?>
                        <span class="badge bg-danger">Công nợ</span>
                    <?php else: ?>
                        <span class="badge bg-success">Thanh toán</span>
                    <?php endif; ?>
                </td>
                <td><?= $t['created_at'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>

</body>
</html>