<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Công Nợ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container py-4">

        <h3 class="fw-bold text-primary mb-3">Sửa Công Nợ</h3>

        <div class="card shadow-sm">
            <div class="card-body">

                <form action="index.php?act=cap-nhat-congno&id=<?= $congno['id'] ?>" method="POST">

                    <input type="hidden" name="id" value="<?= $congno['id'] ?>">

                    <div class="mb-3">
                        <label class="form-label">Nhà cung cấp</label>
                        <select name="nha_cung_cap_id" class="form-select">
                            <?php foreach ($nha_cung_caps as $ncc): ?>
                                <option value="<?= $ncc['id'] ?>"
                                    <?= $congno['nha_cung_cap_id'] == $ncc['id'] ? 'selected' : '' ?>>
                                    <?= $ncc['ten'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tour</label>
                        <select name="tour_id" class="form-select">
                            <?php foreach ($tours as $tour): ?>
                                <option value="<?= $tour['id'] ?>"
                                    <?= $congno['tour_id'] == $tour['id'] ? 'selected' : '' ?>>
                                    <?= $tour['ten'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Số tiền</label>
                        <input type="number" name="sotien" value="<?= $congno['sotien'] ?>" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Loại</label>
                        <select name="loai" class="form-select">
                            <option value="con_no" <?= $congno['loai'] == 'con_no' ? 'selected' : '' ?>>Còn nợ</option>
                            <option value="da_thanh_toan" <?= $congno['loai'] == 'da_thanh_toan' ? 'selected' : '' ?>>Đã thanh toán</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Ghi chú</label>
                        <textarea name="ghi_chu" class="form-control"><?= $congno['ghi_chu'] ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Ngày</label>
                        <input type="date" name="ngay" value="<?= $congno['ngay'] ?>" class="form-control">
                    </div>

                    <button class="btn btn-primary">Cập nhật</button>
                    <a href="index.php?act=quan-ly-congno" class="btn btn-secondary">Hủy</a>

                </form>

            </div>
        </div>

    </div>

</body>

</html>