<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Địa điểm</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./views/chung/css/form.css" />
</head>
<body>
    <div class="content-wrapper">
        <div class="content-container">
            <div class="container">
                <h1>Thêm Địa điểm mới</h1>
                <form action="index.php?act=them-dia-diem" method="POST">

                    <div class="form-group">
                        <label for="ten">Tên Địa điểm: <span style="color: red;">*</span></label>
                        <input type="text" id="ten" name="ten" required>
                        <?php if (isset($errors['ten'])): ?>
                            <span style="color: red;"><?php echo $errors['ten']; ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="tour_id">Tour:</label>
                        <select id="tour_id" name="tour_id">
                            <option value="">-- Chọn Tour --</option>
                            <?php foreach ($listTour as $tour): ?>
                                <option value="<?php echo $tour['id']; ?>"><?php echo htmlspecialchars($tour['ten']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="loai">Loại:</label>
                        <select id="loai" name="loai">
                            <option value="destination">Điểm đến (Destination)</option>
                            <option value="checkpoint">Điểm tập trung (Checkpoint)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="moTa">Mô tả:</label>
                        <textarea id="moTa" name="moTa"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="tgDi">Thời gian đi: <span style="color: red;">*</span></label>
                        <input type="date" id="tgDi" name="tgDi" required>
                        <?php if (isset($errors['tgDi'])): ?>
                            <span style="color: red;"><?php echo $errors['tgDi']; ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="tgVe">Thời gian về: <span style="color: red;">*</span></label>
                        <input type="date" id="tgVe" name="tgVe" required>
                        <?php if (isset($errors['tgVe'])): ?>
                            <span style="color: red;"><?php echo $errors['tgVe']; ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Thứ tự sẽ được tự động tính toán -->

                    <div class="form-group">
                        <label for="trangThai">Trạng thái:</label>
                        <select id="trangThai" name="trangThai">
                            <option value="pending">Chờ duyệt (Pending)</option>
                            <option value="active">Hoạt động (Active)</option>
                            <option value="completed">Hoàn thành (Completed)</option>
                        </select>
                    </div>

                    <div class="button-group">
                        <button type="submit" class="btn-submit">Thêm Địa điểm</button>
                        <button type="button" class="btn-cancel" onclick="window.location.href='index.php?act=quan-ly-dia-diem'">Hủy</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
