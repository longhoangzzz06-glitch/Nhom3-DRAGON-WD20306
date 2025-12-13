<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Công Nợ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-4">

    <h3 class="fw-bold text-primary mb-3">Thêm Công Nợ</h3>

    <div class="card shadow-sm">
        <div class="card-body">

            <form action="index.php?act=them-congno" method="POST">

                <!-- Nhà cung cấp -->
                <div class="mb-3">
                    <label class="form-label">Nhà cung cấp</label>
                    <select name="nha_cung_cap_id" class="form-select" required>
                        <option value="">-- Chọn nhà cung cấp --</option>
                        <?php foreach ($nha_cung_caps as $ncc): ?>
                            <option value="<?= $ncc['id'] ?>"><?= $ncc['ten'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Tour -->
                <div class="mb-3">
                    <label class="form-label">Tour</label>
                    <select name="tour_id" class="form-select" required>
                        <option value="">-- Chọn tour --</option>
                        <?php foreach ($tours as $tour): ?>
                            <option value="<?= $tour['id'] ?>"><?= $tour['ten'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Số tiền -->
                <div class="mb-3">
                    <label class="form-label">Số tiền</label>
                    <input type="number" name="sotien" class="form-control" required>
                </div>

                <!-- Loại -->
                <div class="mb-3">
                    <label class="form-label">Loại</label>
                    <select class="form-select" name="loai" required>
                        <option value="con_no">Còn nợ</option>
                        <option value="da_thanh_toan">Đã thanh toán</option>
                    </select>
                </div>

                <!-- Ghi chú -->
                <div class="mb-3">
                    <label class="form-label">Ghi chú</label>
                    <textarea name="ghi_chu" rows="3" class="form-control"></textarea>
                </div>

                <!-- Ngày -->
                <div class="mb-3">
                    <label class="form-label">Ngày</label>
                    <input type="date" name="ngay" class="form-control" required>
                </div>

                <button class="btn btn-primary">Lưu</button>
                <a href="index.php?act=quan-ly-congno" class="btn btn-secondary">Hủy</a>

            </form>

        </div>
    </div>

</div>

</body>
</html>
