<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">

    <h3>📄 Chi tiết công nợ: <b><?= $debt['doi_tuong'] ?></b></h3>

    <div class="card mt-3">
        <div class="card-body">
            <p><b>Loại công nợ:</b> <?= $debt['loai'] ?></p>
            <p><b>Tổng tiền:</b> <?= number_format($debt['so_tien']) ?> đ</p>
            <p><b>Đã thanh toán:</b> <?= number_format($debt['so_tien_da_tra']) ?> đ</p>
            <p><b>Còn nợ:</b> <span class="text-danger fw-bold">
                <?= number_format($debt['so_tien'] - $debt['so_tien_da_tra']) ?> đ
            </span></p>
            <p><b>Hạn thanh toán:</b> <?= $debt['han_thanh_toan'] ?></p>
        </div>
    </div>

    <h4 class="mt-4">🧾 Lịch sử thanh toán</h4>

    <table class="table table-bordered">
        <thead class="table-secondary">
        <tr>
            <th>Số tiền</th>
            <th>Ghi chú</th>
            <th>Ngày tạo</th>
        </tr>
        </thead>

        <tbody>
        <?php foreach ($payments as $row): ?>
            <tr>
                <td><?= number_format($row['so_tien']) ?> đ</td>
                <td><?= $row['ghi_chu'] ?></td>
                <td><?= $row['created_at'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <?php include "payment_add.php"; ?>

</div>
</body>
</html>

