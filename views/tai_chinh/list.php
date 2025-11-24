<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="m-0">Quản lý Thu - Chi</h3>
        <div>
            <a href="index.php?module=finance&action=create" class="btn btn-primary">+ Thêm giao dịch</a>
            <a href="index.php?module=finance&action=report" class="btn btn-secondary">Báo cáo</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-hover table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Tour</th>
                        <th>Loại</th>
                        <th>Hạng mục</th>
                        <th>Số tiền</th>
                        <th>Ghi chú</th>
                        <th>Ngày</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($transactions as $row): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['tour_name']) ?></td>
                        <td>
                            <?php if ($row['type'] == 'income') echo '<span class="badge bg-success">Thu</span>';
                                  else echo '<span class="badge bg-danger">Chi</span>'; ?>
                        </td>
                        <td><?= htmlspecialchars($row['category']) ?></td>
                        <td><?= number_format($row['amount']) ?> <?= htmlspecialchars($row['currency']) ?></td>
                        <td><?= htmlspecialchars($row['note']) ?></td>
                        <td><?= $row['created_at'] ?></td>
                        <td>
                            <a class="btn btn-sm btn-warning" href="index.php?module=finance&action=edit&id=<?= $row['id'] ?>">Sửa</a>
                            <a class="btn btn-sm btn-danger" href="index.php?module=finance&action=delete&id=<?= $row['id'] ?>" onclick="return confirm('Xóa giao dịch này?')">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Pagination simple -->
            <nav>
                <ul class="pagination">
                    <?php for($p=1;$p<= $totalPages;$p++): ?>
                        <li class="page-item <?= ($p==$page)?'active':'' ?>">
                            <a class="page-link" href="index.php?module=finance&action=index&page=<?= $p ?>"><?= $p ?></a>
                        </li>
                    <?php endfor;?>
                </ul>
            </nav>

        </div>
    </div>
</div>

</body>

</html>