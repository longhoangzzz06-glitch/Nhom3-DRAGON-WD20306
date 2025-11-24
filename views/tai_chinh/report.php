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
    <h3>Báo cáo lãi/lỗ theo tour</h3>

    <form class="row g-3 mb-3" method="get" action="index.php">
        <input type="hidden" name="module" value="finance">
        <input type="hidden" name="action" value="report">
        <div class="col-md-4">
            <label class="form-label">Tour</label>
            <select name="tour_id" class="form-select">
                <option value="">-- Chọn tour --</option>
                <?php foreach($tours as $t): ?>
                    <option value="<?= $t['id'] ?>" <?= (isset($_GET['tour_id']) && $_GET['tour_id']==$t['id'])?'selected':'' ?>>
                        <?= htmlspecialchars($t['tour_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-3">
            <label class="form-label">Từ ngày</label>
            <input type="date" name="from" class="form-control" value="<?= htmlspecialchars($from) ?>">
        </div>

        <div class="col-md-3">
            <label class="form-label">Đến ngày</label>
            <input type="date" name="to" class="form-control" value="<?= htmlspecialchars($to) ?>">
        </div>

        <div class="col-md-2 align-self-end">
            <button class="btn btn-primary">Xem báo cáo</button>
        </div>
    </form>

    <?php if ($report): ?>
        <div class="card">
            <div class="card-body">
                <p><b>Tổng thu:</b> <?= number_format($report['total_income'] ?? 0) ?> đ</p>
                <p><b>Tổng chi:</b> <?= number_format($report['total_expense'] ?? 0) ?> đ</p>
                <p><b>Lợi nhuận:</b> <?= number_format( ($report['total_income'] ?? 0) - ($report['total_expense'] ?? 0) ) ?> đ</p>
            </div>
        </div>
    <?php endif; ?>

</div>
   
</body>
</html>