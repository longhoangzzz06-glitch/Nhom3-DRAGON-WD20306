<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./views/quanly_HDV/css/danhsach_HDV.css" />
</head>
<body>
    <h2>Danh sách hợp đồng</h2>
    <a href="index.php?&act=create-contract">+ Thêm hợp đồng</a>

    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Nhà cung cấp</th>
            <th>Số hợp đồng</th>
            <th>Ngày bắt đầu</th>
            <th>Ngày kết thúc</th>
            <th>Hạn thanh toán</th>
            <th>Tệp hợp đồng</th>
            <th>Hành động</th>
        </tr>

        <?php foreach ($contracts as $c): ?>
        <tr>
            <td><?= $c['id'] ?></td>
            <td><?= $c['supplier_name'] ?></td>
            <td><?= $c['contract_number'] ?></td>
            <td><?= $c['start_date'] ?></td>
            <td><?= $c['end_date'] ?></td>
            <td><?= $c['payment_due'] ?></td>
            <td>
                <?php if ($c['file_path']): ?>
                    <a href="<?= $c['file_path'] ?>" download>Tải</a>
                <?php endif; ?>
            </td>
            <td>
                <a href="index.php?act=edit&id=<?= $c['id'] ?>">Sửa</a>
                |
                <a onclick="return confirm('Xóa?')" href="index.php?controller=contract&action=delete&id=<?= $c['id'] ?>">Xóa</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    
</body>
</html>