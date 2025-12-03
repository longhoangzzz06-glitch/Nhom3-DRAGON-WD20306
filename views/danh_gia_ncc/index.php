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
        <h3 class="text-primary fw-bold">Danh Sách Đánh Giá NCC</h3>
        <a href="index.php?act=danhgia&method=create" class="btn btn-success">+ Thêm đánh giá</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nhà cung cấp</th>
                        <th>Tour</th>
                        <th>Điểm</th>
                        <th>Bình luận</th>
                        <th>Ngày đánh giá</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($danhgias)): ?>
                        <?php foreach($danhgias as $d): ?>
                            <tr>
                                <td><?= $d['id'] ?></td>
                                <td><?= $d['nha_cung_cap_id'] ?></td>
                                <td><?= $d['tour_id'] ?></td>
                                <td><?= $d['diem'] ?></td>
                                <td><?= $d['binh_luan'] ?></td>
                                <td><?= $d['ngay_danh_gia'] ?></td>
                                <td>
                                    <a href="index.php?act=danhgia&method=edit&id=<?= $d['id'] ?>" class="btn btn-sm btn-warning">Sửa</a>
                                    <a href="index.php?act=danhgia&method=delete&id=<?= $d['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Xóa đánh giá này?')">Xóa</a>
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