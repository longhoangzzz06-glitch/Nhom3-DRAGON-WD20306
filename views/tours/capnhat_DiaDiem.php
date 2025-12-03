<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật Địa điểm</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./views/chung/css/form.css" />
</head>
<body>
    <div class="content-wrapper">
        <div class="content-container">
            <div class="container">
                <h1>Cập nhật Địa điểm</h1>
                <form action="index.php?act=cap-nhat-dia-diem&id=<?php echo $diaDiem['id']; ?>" method="POST">

                    <div class="form-group">
                        <label for="ten">Tên Địa điểm: <span style="color: red;">*</span></label>
                        <input type="text" id="ten" name="ten" value="<?php echo htmlspecialchars($diaDiem['ten']); ?>" required>
                        <?php if (isset($errors['ten'])): ?>
                            <span style="color: red;"><?php echo $errors['ten']; ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="tour_id">Tour:</label>
                        <select id="tour_id" name="tour_id">
                            <option value="">-- Chọn Tour --</option>
                            <?php foreach ($listTour as $tour): ?>
                                <option value="<?php echo $tour['id']; ?>" <?php echo ($diaDiem['tour_id'] == $tour['id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($tour['ten']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="loai">Loại:</label>
                        <select id="loai" name="loai">
                            <option value="destination" <?php echo ($diaDiem['loai'] == 'destination') ? 'selected' : ''; ?>>Điểm đến (Destination)</option>
                            <option value="checkpoint" <?php echo ($diaDiem['loai'] == 'checkpoint') ? 'selected' : ''; ?>>Điểm tập trung (Checkpoint)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="moTa">Mô tả:</label>
                        <textarea id="moTa" name="moTa"><?php echo htmlspecialchars($diaDiem['moTa']); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="tgDi">Thời gian đi: <span style="color: red;">*</span></label>
                        <input type="date" id="tgDi" name="tgDi" value="<?php echo $diaDiem['tgDi']; ?>" required>
                        <?php if (isset($errors['tgDi'])): ?>
                            <span style="color: red;"><?php echo $errors['tgDi']; ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="tgVe">Thời gian về: <span style="color: red;">*</span></label>
                        <input type="date" id="tgVe" name="tgVe" value="<?php echo $diaDiem['tgVe']; ?>" required>
                        <?php if (isset($errors['tgVe'])): ?>
                            <span style="color: red;"><?php echo $errors['tgVe']; ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="thuTu">Thứ tự:</label>
                        <input type="number" id="thuTu" name="thuTu" value="<?php echo $diaDiem['thuTu']; ?>">
                    </div>

                    <div class="button-group">
                        <button type="submit" class="btn-submit">Cập nhật</button>
                        <button type="button" class="btn-cancel" onclick="window.location.href='index.php?act=quan-ly-dia-diem'">Hủy</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
