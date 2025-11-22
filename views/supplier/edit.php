<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./views/quanly_HDV/css/add_HDV.css" />
</head>
<body>
<h2>Sửa hợp đồng</h2>

<form method="POST" enctype="multipart/form-data" action="index.php?controller=contract&action=update">
    <input type="hidden" name="id" value="<?= $contract['id'] ?>">

    <div class="form-group">
        <label for="contract_number">Số hợp đồng: <span style="color: red;">*</span></label>
        <input type="number" id="" name="contract_number" required>
    </div>
    <div class="form-group">
        <label for="start_date">Ngày bắt đầu: <span style="color: red;">*</span></label>
        <input type="date" id="" name="start_date" required>
    </div>
    <div class="form-group">
        <label for="end_date">Ngày kết thúc: <span style="color: red;">*</span></label>
        <input type="date" id="" name="end_date" required>
    </div>
    <div class="form-group">
        <label for="payment_due">Hạn thanh toán: <span style="color: red;">*</span></label>
        <input type="date" id="" name="payment_due" required>
    </div>
    <div class="form-group">
        <label for="file">File mới: <span style="color: red;">*</span></label>
        <input type="file" id="" name="filr" required>
    </div>

    <div class="button-group">
        <button type="submit" class="btn-submit">Thêm Hướng dẫn viên</button>
        <button type="button" class="btn-cancel" onclick="window.location.href='index.php?act=suppliers'">Hủy</button>
    </div>
</form>
    
</body>
</html>