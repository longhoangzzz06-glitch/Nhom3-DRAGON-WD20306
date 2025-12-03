<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./views/chung/css/form.css" />
</head>
<body>
    <div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="text-primary fw-bold">Danh Sách Công Nợ</h3>
        <a href="index.php?act=congno&method=create" class="btn btn-success">+ Thêm công nợ</a>
    </div>

    <!-- Table -->
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nhà cung cấp</th>
                        <th>Tour</th>
                        <th>Số tiền</th>
                        <th>Loại</th>
                        <th>Ngày</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($congnos)): ?>
                        <?php foreach($congnos as $c): ?>
                            <tr>
                                <td><?= $c['id'] ?></td>
                                <td><?= $c['nha_cung_cap_id'] ?></td>
                                <td><?= $c['tour_id'] ?></td>
                                <td><?= number_format($c['sotien']) ?></td>
                                <td><?= $c['loai'] ?></td>
                                <td><?= $c['ngay'] ?></td>
                                <td>
                                    <a href="index.php?act=congno&method=edit&id=<?= $c['id'] ?>" class="btn btn-sm btn-warning">Sửa</a>
                                    <a href="index.php?act=congno&method=delete&id=<?= $c['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Xóa công nợ này?')">Xóa</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="7" class="text-center text-muted">Không có dữ liệu</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

</body>
</html>