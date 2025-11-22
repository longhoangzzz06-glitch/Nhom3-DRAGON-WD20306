<div class="container mt-4">
    <div class="d-flex justify-content-between mb-3">
        <h3 class="fw-bold">Danh sách nhắc hạn thanh toán</h3>
        <a href="index.php?controller=paymentReminder&action=create" 
           class="btn btn-primary">+ Thêm nhắc hạn</a>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Nhà cung cấp</th>
                        <th>Hợp đồng</th>
                        <th>Số tiền</th>
                        <th>Ngày đến hạn</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($reminders as $r): ?>
                    <tr>
                        <td><?= $r['id'] ?></td>
                        <td><?= $r['supplier_name'] ?></td>
                        <td><?= $r['contract_code'] ?></td>
                        <td><?= number_format($r['amount']) ?>₫</td>
                        <td class="<?= (strtotime($r['due_date']) < time()) ? 'text-danger fw-bold' : '' ?>">
                            <?= $r['due_date'] ?>
                        </td>
                        <td>
                            <?php if($r["status"] == "pending") : ?>
                                <span class="badge bg-warning">Chờ đến hạn</span>
                            <?php elseif($r["status"] == "sent") : ?>
                                <span class="badge bg-info">Đã gửi nhắc</span>
                            <?php elseif($r["status"] == "paid") : ?>
                                <span class="badge bg-success">Đã thanh toán</span>
                            <?php else : ?>
                                <span class="badge bg-danger">Trễ hạn</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
