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
    <h2 class="mb-4">📌 Danh sách công nợ</h2>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
        <tr>
            <th>Đối tác / Khách hàng</th>
            <th>Loại công nợ</th>
            <th>Tổng tiền</th>
            <th>Đã thanh toán</th>
            <th>Còn nợ</th>
            <th>Hạn thanh toán</th>
            <th>Chi tiết</th>
        </tr>
        </thead>

        <tbody>
        <?php foreach ($data as $row): ?>
            <tr class="<?= ($row['con_no'] > 0 && strtotime($row['han_thanh_toan']) < time()) ? 'table-danger' : '' ?>">
                <td><?= $row['doi_tuong'] ?></td>
                <td><?= $row['loai'] ?></td>
                <td><?= number_format($row['so_tien']) ?> đ</td>
                <td><?= number_format($row['so_tien_da_tra']) ?> đ</td>
                <td class="fw-bold text-danger"><?= number_format($row['con_no']) ?> đ</td>
                <td><?= $row['han_thanh_toan'] ?></td>
                <td>
                    <a class="btn btn-primary btn-sm"
                       href="index.php?module=debt&action=detail&id=<?= $row['id'] ?>">
                        Xem chi tiết
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>

    </table>
</div>

</body>
</html>