<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="container mt-4">
    <h2 class="mb-4">Thêm Công Nợ Nhà Cung Cấp</h2>

    <form action="/supplierDebts/store" method="POST" class="card p-4 shadow-sm">

        <div class="mb-3">
            <label class="form-label">Nhà Cung Cấp</label>
            <select name="supplier_id" class="form-control">
                <?php foreach ($suppliers as $s): ?>
                    <option value="<?= $s['id'] ?>"><?= $s['supplier_name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Loại Dịch Vụ</label>
            <input type="text" name="service_type" class="form-control" placeholder="VD: Hotel, Transport..." />
        </div>

        <div class="mb-3">
            <label class="form-label">Tổng Công Nợ</label>
            <input type="number" class="form-control" name="total_debt" required />
        </div>

        <div class="mb-3">
            <label class="form-label">Đã Thanh Toán</label>
            <input type="number" class="form-control" name="paid_amount" required />
        </div>

        <button class="btn btn-success">Lưu Công Nợ</button>
        <a href="/supplierDebts" class="btn btn-secondary">Quay Lại</a>

    </form>
</div>

</body>
</html>