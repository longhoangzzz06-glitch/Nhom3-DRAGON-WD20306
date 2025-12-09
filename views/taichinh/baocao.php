<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./views/chung/css/form.css" />
</head>
<body>
    <div class="container mt-4">
    <h3 class="text-primary fw-bold">Báo Cáo Tài Chính Tour</h3>

    <?php if(!empty($baocao)): ?>
        <div class="card shadow-sm mt-3 p-3">
            <p><strong>Doanh thu:</strong> <?= number_format($baocao['doanhthu']) ?> VND</p>
            <p><strong>Chi phí:</strong> <?= number_format($baocao['chiphi']) ?> VND</p>
            <p><strong>Lãi/Lỗ:</strong> <?= number_format($baocao['lai_lo']) ?> VND</p>
        </div>
    <?php else: ?>
        <p class="text-muted mt-3">Chưa có dữ liệu để báo cáo</p>
    <?php endif; ?>
</div>

</body>
</html>