<h2>Danh sách Nhà Cung Cấp</h2>

<a href="index.php?controller=provider&action=create" class="btn btn-primary mb-3">Thêm nhà cung cấp</a>

<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>Tên đơn vị</th>
        <th>Loại</th>
        <th>Liên hệ</th>
        <th>Hành động</th>
    </tr>

    <?php foreach ($providers as $p): ?>
    <tr>
        <td><?= $p['id'] ?></td>
        <td><?= $p['name'] ?></td>
        <td><?= $p['type'] ?></td>
        <td><?= $p['phone'] ?> / <?= $p['email'] ?></td>
        <td>
            <a href="index.php?controller=provider&action=edit&id=<?= $p['id'] ?>" class="btn btn-warning btn-sm">Sửa</a>
            <a href="index.php?controller=provider&action=delete&id=<?= $p['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Xóa?')">Xóa</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
