<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Đánh Giá NCC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-4">

    <h3 class="fw-bold text-primary mb-3">Thêm Đánh Giá Nhà Cung Cấp</h3>

    <div class="card shadow-sm">
        <div class="card-body">

            <form action="index.php?act=them-danhgia" method="POST">
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

                <!-- Điểm -->
                <div class="mb-3">
                    <label class="form-label">Điểm đánh giá</label>
                    <select name="diem" class="form-select" required>
                        <option value="">-- Chọn điểm --</option>
                        <?php for($i=1; $i<=5; $i++): ?>
                            <option value="<?= $i ?>"><?= $i ?>/5</option>
                        <?php endfor; ?>
                    </select>
                </div>

                <!-- Bình luận -->
                <div class="mb-3">
                    <label class="form-label">Bình luận</label>
                    <textarea name="binh_luan" rows="3" class="form-control"></textarea>
                </div>

                <!-- Ngày đánh giá -->
                <div class="mb-3">
                    <label class="form-label">Ngày đánh giá</label>
                    <input type="date" name="ngay_danh_gia" class="form-control" required>
                </div>

                <button class="btn btn-primary">Lưu</button>
                <a href="index.php?act=quan-ly-danhgia" class="btn btn-secondary">Hủy</a>

            </form>
        </div>
    </div>

</div>

</body>
</html>
