<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="card mt-4">
    <div class="card-header bg-primary text-white">
        Thêm thanh toán mới
    </div>

    <div class="card-body">
        <form method="post" action="index.php?module=debt&action=savePayment">
            <input type="hidden" name="debt_id" value="<?= $debt['id'] ?>">

            <div class="mb-3">
                <label class="form-label">Số tiền thanh toán</label>
                <input type="number" class="form-control" name="amount" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Ghi chú</label>
                <textarea class="form-control" name="note" placeholder="Nhập ghi chú (nếu có)..."></textarea>
            </div>

            <button class="btn btn-success">Lưu thanh toán</button>
        </form>
    </div>
</div>
  
</body>
</html>