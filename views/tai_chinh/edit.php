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
        <h3>Chỉnh sửa giao dịch</h3>
        <div class="card">
            <div class="card-body">
                <form method="post" action="index.php?module=finance&action=update">
                    <input type="hidden" name="id" value="<?= $tx['id'] ?>">

                    <div class="mb-3">
                        <label class="form-label">Tour</label>
                        <select name="tour_id" class="form-select" required>
                            <?php foreach ($tours as $t): ?>
                                <option value="<?= $t['id'] ?>" <?= ($t['id'] == $tx['tour_id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($t['tour_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Loại</label>
                        <select name="type" class="form-select" required>
                            <option value="income" <?= $tx['type'] == 'income' ? 'selected' : '' ?>>Thu</option>
                            <option value="expense" <?= $tx['type'] == 'expense' ? 'selected' : '' ?>>Chi</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Hạng mục</label>
                        <input type="text" name="category" class="form-control" value="<?= htmlspecialchars($tx['category']) ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Số tiền</label>
                        <input type="number" name="amount" class="form-control" step="0.01" value="<?= $tx['amount'] ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tiền tệ</label>
                        <input type="text" name="currency" class="form-control" value="<?= $tx['currency'] ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Ghi chú</label>
                        <textarea name="note" class="form-control"><?= htmlspecialchars($tx['note']) ?></textarea>
                    </div>

                    <button class="btn btn-success">Cập nhật</button>
                    <a class="btn btn-secondary" href="index.php?module=finance&action=index">Hủy</a>
                </form>
            </div>
        </div>
    </div>

</body>

</html>