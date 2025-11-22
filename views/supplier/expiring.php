<h2>Hợp đồng sắp hết hạn (≤ 30 ngày)</h2>

<table border="1" cellpadding="10">
    <tr>
        <th>Nhà cung cấp</th>
        <th>Số HĐ</th>
        <th>Kết thúc</th>
        <th>Số ngày còn lại</th>
    </tr>

    <?php foreach ($contracts as $c): ?>
    <tr>
        <td><?= $c['supplier_name'] ?></td>
        <td><?= $c['contract_number'] ?></td>
        <td><?= $c['end_date'] ?></td>
        <td><?= (strtotime($c['end_date']) - time()) / 86400 ?></td>
    </tr>
    <?php endforeach; ?>
</table>
