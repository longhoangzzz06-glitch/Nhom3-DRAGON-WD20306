<?php
// Giả sử $hopdong, $nha_cung_caps và $tours được controller truyền sang
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Hợp Đồng</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="./views/chung/css/form.css" />
</head>
<body>
<div class="container mt-5">
    <h3 class="text-primary mb-4">Sửa Hợp Đồng</h3>

    <?php if (!empty($hopdong)): ?>
    <form action="index.php?act=cap-nhat-hopdong&id=<?= $hopdong['id'] ?>" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Nhà cung cấp</label>
            <select name="nha_cung_cap_id" class="form-control" required>
                <?php foreach($nha_cung_caps as $ncc): ?>
                    <option value="<?= $ncc['id'] ?>" <?= $hopdong['nha_cung_cap_id']==$ncc['id']?'selected':'' ?>>
                        <?= $ncc['ten_nha_cung_cap'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Tour</label>
            <select name="tour_id" class="form-control" required>
                <?php foreach($tours as $tour): ?>
                    <option value="<?= $tour['id'] ?>" <?= $hopdong['tour_id']==$tour['id']?'selected':'' ?>>
                        <?= $tour['ten_tour'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Giá</label>
            <input type="number" name="gia" class="form-control" value="<?= $hopdong['gia'] ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">File Hợp Đồng</label>
            <?php if ($hopdong['file_hop_dong']): ?>
                <p>File hiện tại: <a href="<?= $hopdong['file_hop_dong'] ?>" target="_blank">Xem file</a></p>
            <?php endif; ?>
            <input type="file" name="file_hop_dong" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Ghi chú</label>
            <textarea name="ghi_chu" class="form-control"><?= $hopdong['ghi_chu'] ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Cập nhật</button>
        <a href="index.php?act=quan-ly-hopdong" class="btn btn-secondary">Hủy</a>
    </form>
    <?php else: ?>
        <p class="text-danger">Hợp đồng không tồn tại.</p>
    <?php endif; ?>
</div>
</body>
</html>
