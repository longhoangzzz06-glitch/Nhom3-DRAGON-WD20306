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
        <h3 class="text-primary fw-bold">Danh Sách Hợp Đồng</h3>
        <a href="index.php?act=hopdong&method=create" class="btn btn-success">+ Thêm hợp đồng</a>
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
                        <th>Giá</th>
                        <th>File hợp đồng</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($hopdongs)): ?>
                        <?php foreach ($hopdongs as $h): ?>
                            <tr>
                                <td><?= $h['id'] ?></td>
                                <td><?= $h['nha_cung_cap_id'] ?></td>
                                <td><?= $h['tour_id'] ?></td>
                                <td><?= number_format($h['gia']) ?></td>
                                <td>
                                    <?php if($h['file_hop_dong']): ?>
                                        <a href="<?= $h['file_hop_dong'] ?>" target="_blank">Xem file</a>
                                    <?php else: ?>
                                        <span class="text-muted">Chưa upload</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="index.php?act=hopdong&method=edit&id=<?= $h['id'] ?>" class="btn btn-sm btn-warning">Sửa</a>
                                    <a href="index.php?act=hopdong&method=delete&id=<?= $h['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Xóa hợp đồng này?')">Xóa</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6" class="text-center text-muted">Không có dữ liệu</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

</body>
</html>