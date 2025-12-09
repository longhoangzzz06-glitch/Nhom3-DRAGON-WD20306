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

 <!-- $nccs, $page, $totalPages, $keyword, $loai_dich_vu được controller truyền sang -->


<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="text-primary fw-bold">Danh Sách Nhà Cung Cấp</h3>
        <a href="index.php?act=nha_cung_cap&method=create" class="btn btn-success">
            + Thêm nhà cung cấp
        </a>
    </div>

    <!-- Search -->
    <form class="row g-2 mb-3" method="GET">
        <input type="hidden" name="act" value="nha_cung_cap">

        <div class="col-md-4">
            <input type="text" name="keyword" class="form-control" placeholder="Tìm theo tên..."
                value="<?= $_GET['keyword'] ?? '' ?>">
        </div>

        <div class="col-md-4">
            <input type="text" name="loai_dich_vu" class="form-control" placeholder="Loại dịch vụ..."
                value="<?= $_GET['loai_dich_vu'] ?? '' ?>">
        </div>

        <div class="col-md-4">
            <button class="btn btn-primary w-100">Tìm kiếm</button>
        </div>
    </form>

    <!-- Table -->
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Logo</th>
                        <th>Tên NCC</th>
                        <th>Dịch vụ</th>
                        <th>SĐT</th>
                        <th>Email</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($nccs)): ?>
                        <?php foreach ($nccs as $n): ?>
                            <tr>
                                <td><?= $n['id'] ?></td>
                                <td>
                                    <?php if (!empty($n['logo'])): ?>
                                        <img src="<?= $n['logo'] ?>" style="width:40px;height:40px;border-radius:5px;object-fit:cover">
                                    <?php else: ?>
                                        <span class="text-muted">Không có</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= $n['ten'] ?></td>
                                <td><?= $n['loai_dich_vu'] ?></td>
                                <td><?= $n['dien_thoai'] ?></td>
                                <td><?= $n['email'] ?></td>
                                <td>
                                    <button class="btn btn-sm btn-info text-white" data-bs-toggle="modal"
                                        data-bs-target="#viewModal<?= $n['id'] ?>">Xem</button>
                                    <a href="index.php?act=nha_cung_cap&method=edit&id=<?= $n['id'] ?>"
                                        class="btn btn-sm btn-warning">Sửa</a>
                                    <a href="index.php?act=nha_cung_cap&method=delete&id=<?= $n['id'] ?>"
                                        class="btn btn-sm btn-danger" onclick="return confirm('Xóa nhà cung cấp này?')">Xóa</a>
                                </td>
                            </tr>

                            <!-- Modal chi tiết -->
                            <div class="modal fade" id="viewModal<?= $n['id'] ?>" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Chi tiết Nhà Cung Cấp</h5>
                                            <button class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body row">
                                            <div class="col-md-4">
                                                <?php if ($n['logo']): ?>
                                                    <img src="<?= $n['logo'] ?>" class="img-fluid rounded border">
                                                <?php else: ?>
                                                    <p class="text-muted">Không có logo</p>
                                                <?php endif; ?>
                                            </div>
                                            <div class="col-md-8">
                                                <p><strong>Tên:</strong> <?= $n['ten'] ?></p>
                                                <p><strong>Dịch vụ:</strong> <?= $n['loai_dich_vu'] ?></p>
                                                <p><strong>Điện thoại:</strong> <?= $n['dien_thoai'] ?></p>
                                                <p><strong>Email:</strong> <?= $n['email'] ?></p>
                                                <p><strong>Địa chỉ:</strong> <?= $n['dia_chi'] ?></p>
                                                <p><strong>Ghi chú:</strong> <?= nl2br($n['ghi_chu']) ?></p>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-3">Không có dữ liệu</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <?php if ($totalPages > 1): ?>
        <nav class="mt-3">
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                        <a class="page-link"
                            href="index.php?act=nha_cung_cap&page=<?= $i ?>&keyword=<?= $keyword ?>&loai_dich_vu=<?= $loai_dich_vu ?>">
                            <?= $i ?>
                        </a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    <?php endif; ?>

</div>

</body>
</html>