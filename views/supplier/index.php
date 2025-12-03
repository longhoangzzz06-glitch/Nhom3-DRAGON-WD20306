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
        <h3 class="text-primary fw-bold">Danh Sách Nhà Cung Cấp</h3>
        <a href="index.php?act=supplier&method=create" class="btn btn-success">
            + Thêm nhà cung cấp
        </a>
    </div>

    <!-- Search -->
    <form class="row g-2 mb-3" method="GET">
        <input type="hidden" name="act" value="supplier">

        <div class="col-md-4">
            <input 
                type="text" 
                name="keyword" 
                class="form-control" 
                placeholder="Tìm theo tên..."
                value="<?= $_GET['keyword'] ?? '' ?>"
            >
        </div>

        <div class="col-md-4">
            <input 
                type="text" 
                name="service" 
                class="form-control" 
                placeholder="Loại dịch vụ..."
                value="<?= $_GET['service'] ?? '' ?>"
            >
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
                    <?php if (!empty($suppliers)): ?>
                        <?php foreach ($suppliers as $s): ?>
                            <tr>
                                <td><?= $s['id'] ?></td>

                                <td>
                                    <?php if (!empty($s['logo'])): ?>
                                        <img src="<?= $s['logo'] ?>" 
                                             style="width:40px; height:40px; border-radius:5px; object-fit:cover">
                                    <?php else: ?>
                                        <span class="text-muted">Không có</span>
                                    <?php endif; ?>
                                </td>

                                <td><?= $s['name'] ?></td>
                                <td><?= $s['service_type'] ?></td>
                                <td><?= $s['contact_phone'] ?></td>
                                <td><?= $s['contact_email'] ?></td>

                                <td>
                                    <!-- View -->
                                    <button 
                                        class="btn btn-sm btn-info text-white" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#viewModal<?= $s['id'] ?>">
                                        Xem
                                    </button>

                                    <!-- Edit -->
                                    <a href="index.php?act=supplier&method=edit&id=<?= $s['id'] ?>" 
                                       class="btn btn-sm btn-warning">
                                        Sửa
                                    </a>

                                    <!-- Delete -->
                                    <a href="index.php?act=supplier&method=delete&id=<?= $s['id'] ?>" 
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Xóa nhà cung cấp này?')">
                                        Xóa
                                    </a>
                                </td>
                            </tr>

                            <!-- Modal Chi tiết -->
                            <div class="modal fade" id="viewModal<?= $s['id'] ?>" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <h5 class="modal-title">Chi tiết nhà cung cấp</h5>
                                            <button class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body row">
                                            
                                            <div class="col-md-4">
                                                <?php if ($s['logo']): ?>
                                                    <img src="<?= $s['logo'] ?>" 
                                                         class="img-fluid rounded border">
                                                <?php else: ?>
                                                    <p class="text-muted">Không có logo</p>
                                                <?php endif; ?>
                                            </div>

                                            <div class="col-md-8">
                                                <p><strong>Tên:</strong> <?= $s['name'] ?></p>
                                                <p><strong>Dịch vụ:</strong> <?= $s['service_type'] ?></p>
                                                <p><strong>Điện thoại:</strong> <?= $s['phone'] ?></p>
                                                <p><strong>Email:</strong> <?= $s['email'] ?></p>
                                                <p><strong>Địa chỉ:</strong> <?= $s['address'] ?></p>
                                                <p><strong>Ghi chú:</strong> <?= nl2br($s['note']) ?></p>
                                                <p><small class="text-muted">Ngày tạo: <?= $s['created_at'] ?></small></p>
                                            </div>

                                        </div>

                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- End Modal -->

                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-3">
                                Không có dữ liệu
                            </td>
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
                           href="index.php?act=supplier&page=<?= $i ?>&keyword=<?= $keyword ?>&service=<?= $service ?>">
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