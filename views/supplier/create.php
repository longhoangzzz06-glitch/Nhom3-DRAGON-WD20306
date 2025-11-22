<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./views/css/add.css" />
</head>

<body>
    <div class="container">
        <h1>Thêm Hợp đồng</h1>

        <form action="index.php?act=them-hdv" method="POST" enctype="multipart/form-data">           
            <div class="form-group">
                <label for="contract_number">Số hợp đồng: <span style="color: red;">*</span></label>
                <input type="text" id="contract_number" name="contract_number" required>
            </div>

            <div class="form-group">
                <label for="start_date">Ngày bắt đầu: <span style="color: red;">*</span></label>
                <input type="date" id="start_date" name="start_date" required>
            </div>

            <div class="form-group">
                <label for="end_date">Ngày kết thúc: <span style="color: red;">*</span></label>
                <input type="date" id="end_date" name="end_date" required>
            </div>

            <div class="form-group">
                <label for="payment_due">Hạn thanh toán: <span style="color: red;">*</span></label>
                <input type="date" id="payment_due" name="payment_due" required>
            </div>

            <div class="form-group">
                <label for="languages">File hợp đồng:</label>
                <input type="file" id="file" name="file">
            </div>

            <div class="button-group">
                <button type="submit" class="btn-submit">Thêm Hợp đồng</button>
                <button type="button" class="btn-cancel" onclick="window.location.href='index.php?act='">Hủy</button>
            </div>
        </form>
    </div>

    <h2>Thêm hợp đồng</h2>

    <form method="POST" enctype="multipart/form-data" action="index.php?controller=contract&action=store">
        Số hợp đồng: <input name="contract_number" required><br>
        Ngày bắt đầu: <input type="date" name="start_date" required><br>
        Ngày kết thúc: <input type="date" name="end_date" required><br>
        Hạn thanh toán: <input type="date" name="payment_due" required><br>
        File hợp đồng: <input type="file" name="file"><br>
        <button type="submit">Lưu</button>
    </form>

</body>

</html>