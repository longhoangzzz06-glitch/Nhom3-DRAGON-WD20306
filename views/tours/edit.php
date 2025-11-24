<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <h1 class="title">Chỉnh sửa Tour</h1>

<form action="" method="post">
    <div class="form-group">
        <label>Tên tour</label>
        <input type="text" name="name" class="form-control" value="<?= $tour['name'] ?>">
    </div>

    <div class="form-group">
        <label>Giá tour</label>
        <input type="number" name="price" class="form-control" value="<?= $tour['price'] ?>">
    </div>

    <div class="form-group">
        <label>Ngày khởi hành</label>
        <input type="date" name="start_date" class="form-control" value="<?= $tour['start_date'] ?>">
    </div>

    <button class="btn btn-success">Cập nhật</button>
</form>

    
</body>
</html>