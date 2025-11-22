<div class="container mt-4">
    <h3 class="fw-bold mb-3 text-danger">Hợp đồng sắp hết hạn (≤ 30 ngày)</h3>

    <div class="card shadow-sm">
        <div class="card-body">

            <table class="table table-bordered table-striped align-middle">
                <thead class="table-danger">
                    <tr>
                        <th>Nhà cung cấp</th>
                        <th>Số HĐ</th>
                        <th>Kết thúc</th>
                        <th>Còn lại</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($contracts as $c): ?>
                        <tr>
                            <td><?= $c['supplier_name'] ?></td>
                            <td><?= $c['contract_number'] ?></td>
                            <td><?= $c['end_date'] ?></td>
                            <td class="fw-bold text-danger">
                                <?= floor((strtotime($c['end_date']) - time()) / 86400) ?> ngày
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>

        </div>
    </div>
</div>
