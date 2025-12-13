<?php
// Kiểm tra biến để tránh lỗi
$nha_cung_caps = $nha_cung_caps ?? [];
$tours = $tours ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Hợp Đồng</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="./views/chung/css/form.css" />
</head>
<body>
<div class="container mt-5">
    <h3 class="text-primary mb-4">Thêm Hợp Đồng</h3>

    <form action="index.php?act=them-hopdong" method="post" enctype="multipart/form-data">

        <!-- SELECT NHÀ CUNG CẤP -->
        <div class="mb-3">
            <label class="form-label">Nhà cung cấp</label>
            <select name="nha_cung_cap_id" class="form-control" required>
                <option value="">-- Chọn nhà cung cấp --</option>

                <?php foreach($nha_cung_caps as $ncc): ?>
                    <option value="<?= $ncc['id'] ?>">
                        <?= $ncc['ten'] ?? $ncc['ten_ncc'] ?? 'Không có tên' ?>
                    </option>
                <?php endforeach; ?>

            </select>
        </div>

        <!-- SELECT TOUR -->
        <div class="mb-3">
            <label class="form-label">Tour</label>
            <select name="tour_id" class="form-control" required>
                <option value="">-- Chọn tour --</option>

                <?php foreach($tours as $tour): ?>
                    <option value="<?= $tour['id'] ?>">
                        <?= $tour['ten'] ?? $tour['ten_tour'] ?? 'Không có tên' ?>
                    </option>
                <?php endforeach; ?>

            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Giá</label>
            <input type="number" name="gia" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">File Hợp Đồng</label>
            <input type="file" name="file_hop_dong" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Ghi chú</label>
            <textarea name="ghi_chu" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i> Thêm hợp đồng</button>
        <a href="index.php?act=quan-ly-hopdong" class="btn btn-secondary">Hủy</a>
    </form>
</div>
</body>
</html>
