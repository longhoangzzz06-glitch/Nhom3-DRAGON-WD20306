<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="container mt-4">
    <h2 class="mb-4">Thêm Công Nợ Khách Hàng</h2>

    <form action="/customerDebts/store" method="POST" class="card p-4 shadow-sm">

        <div class="mb-3">
            <label class="form-label">Khách Hàng</label>
            <select name="customer_id" class="form-control">
                <?php foreach ($customers as $c): ?>
                    <option value="<?= $c['id'] ?>"><?= $c['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Tour</label>
            <select name="tour_id" class="form-control">
                <?php foreach ($tours as $t): ?>
                    <option value="<?= $t['id'] ?>"><?= $t['tour_name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Công Nợ</label>
            <input type="number" class="form-control" name="total_debt" required />
        </div>

        <div class="mb-3">
            <label class="form-label">Đã Thanh Toán</label>
            <input type="number" class="form-control" name="paid_amount" required />
        </div>

        <button class="btn btn-success">Lưu Công Nợ</button>
        <a href="/customerDebts" class="btn btn-secondary">Quay Lại</a>

    </form>
</div>

</body>
</html>