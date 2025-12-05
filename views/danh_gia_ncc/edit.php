<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Đánh Giá</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-4">

    <h3 class="fw-bold text-primary mb-3">Sửa Đánh Giá NCC</h3>

    <div class="card shadow-sm">
        <div class="card-body">

            <form action="index.php?act=quan-ly-danhgia&method=update" method="POST">

                <input type="hidden" name="id" value="<?= $danhgia['id'] ?>">

                <div class="mb-3">
                    <label class="form-label">Nhà cung cấp</label>
                    <input type="number" class="form-control"
                           name="nha_cung_cap_id"
                           value="<?= $danhgia['nha_cung_cap_id'] ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Tour</label>
                    <input type="number" class="form-control"
                           name="tour_id"
                           value="<?= $danhgia['tour_id'] ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Điểm đánh giá</label>
                    <select name="diem" class="form-select">
                        <?php for($i=1;$i<=5;$i++): ?>
                        <option value="<?= $i ?>" <?= ($danhgia['diem']==$i)?'selected':'' ?>>
                            <?= $i ?>/5
                        </option>
                        <?php endfor; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Bình luận</label>
                    <textarea name="binh_luan" class="form-control" rows="3"><?= $danhgia['binh_luan'] ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Ngày đánh giá</label>
                    <input type="date" class="form-control"
                           name="ngay_danh_gia"
                           value="<?= $danhgia['ngay_danh_gia'] ?>">
                </div>

                <button class="btn btn-primary">Cập nhật</button>
                <a href="index.php?act=quan-ly-danhgia" class="btn btn-secondary">Hủy</a>

            </form>

        </div>
    </div>

</div>

</body>
</html>
