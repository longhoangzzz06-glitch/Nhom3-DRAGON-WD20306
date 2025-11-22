<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold">Quản lý hợp đồng</h3>
        <a href="index.php?controller=contract&action=create" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Thêm hợp đồng
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Nhà cung cấp</th>
                        <th>Số HĐ</th>
                        <th>Ngày bắt đầu</th>
                        <th>Ngày kết thúc</th>
                        <th>Hạn thanh toán</th>
                        <th>Tệp</th>
                        <th class="text-center">Hành động</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($contracts as $c): ?>
                        <tr>
                            <td><?= $c['id'] ?></td>
                            <td><?= $c['supplier_name'] ?></td>
                            <td class="fw-semibold"><?= $c['contract_number'] ?></td>
                            <td><?= $c['start_date'] ?></td>
                            <td>
                                <?= $c['end_date'] ?>
                                <?php
                                $days = (strtotime($c['end_date']) - time()) / 86400;
                                if ($days <= 30 && $days >= 0): ?>
                                    <span class="badge bg-warning text-dark ms-1">Sắp hết hạn</span>
                                <?php endif; ?>
                            </td>
                            <td><?= $c['payment_due'] ?></td>
                            <td>
                                <?php if ($c['file_path']): ?>
                                    <a href="<?= $c['file_path'] ?>" class="btn btn-sm btn-secondary" download>
                                        <i class="bi bi-download"></i> Tải
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted">Không có</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <a href="index.php?controller=contract&action=edit&id=<?= $c['id'] ?>"
                                   class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <a onclick="return confirm('Bạn có chắc muốn xóa hợp đồng này?')"
                                   href="index.php?controller=contract&action=delete&id=<?= $c['id'] ?>"
                                   class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash3"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>
        </div>
    </div>
</div>
