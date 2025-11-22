<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa thông tin Hướng dẫn viên</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./views/quanly_HDV/css/edit_HDV.css" />
</head>
<body>
    <div class="container">
        <h1>Sửa thông tin Hướng dẫn viên</h1>
        
        <?php
        if (!isset($hdv) || !$hdv) {
            echo "<p style='color: red;'>Không tìm thấy dữ liệu hướng dẫn viên!</p>";
            exit;
        }
        ?>

        <form action="index.php?act=cap-nhat-hdv&id=<?php echo $hdv['guide_id']; ?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="photo">Ảnh (để trống nếu không thay đổi):</label>
                <?php if ($hdv['photo']): ?>
                    <p style="margin: 0 0 10px 0; font-size: 14px; color: #666;">Ảnh hiện tại:</p>
                    <img src="./uploads/img_HDV/<?php echo htmlspecialchars($hdv['photo']); ?>" alt="Ảnh HDV" class="photo-preview">
                    <input type="hidden" name="old_photo" value="<?php echo htmlspecialchars($hdv['photo']); ?>">
                <?php endif; ?>
                <input type="file" id="photo" name="photo" accept="image/*">
                <p style="font-size: 12px; color: #999; margin-top: 5px;">Chỉ chọn file nếu muốn thay đổi ảnh</p>
            </div>
            
            <div class="form-group">
                <label for="full_name">Họ Tên: <span style="color: red;">*</span></label>
                <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($hdv['full_name']); ?>" required>
            </div>

            <div class="form-group">
                <label for="birth_date">Ngày Sinh: <span style="color: red;">*</span></label>
                <input type="date" id="birth_date" name="birth_date" value="<?php echo $hdv['birth_date']; ?>" required>
            </div>

            <div class="form-group">
                <label for="phone">Số Điện Thoại: <span style="color: red;">*</span></label>
                <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($hdv['phone']); ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email: <span style="color: red;">*</span></label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($hdv['email']); ?>" required>
            </div>

            <div class="form-group">
                <label for="languages">Ngôn Ngữ:</label>
                <input type="text" id="languages" name="languages" value="<?php echo htmlspecialchars($hdv['languages'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label for="experience_years">Kinh Nghiệm (năm):</label>
                <input type="number" id="experience_years" name="experience_years" value="<?php echo htmlspecialchars($hdv['experience_years'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label for="health_status">Tình Trạng Sức Khỏe:</label>
                <input type="text" id="health_status" name="health_status" value="<?php echo htmlspecialchars($hdv['health_status'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label for="status">Trạng Thái:</label>
                <select id="status" name="status">
                    <option value="Đang Hoạt Động" <?php echo ($hdv['status'] === 'Đang Hoạt Động') ? 'selected' : ''; ?>>Đang Hoạt Động</option>
                    <option value="Không Hoạt Động" <?php echo ($hdv['status'] === 'Không Hoạt Động') ? 'selected' : ''; ?>>Không Hoạt Động</option>
                </select>
            </div>

            <div class="button-group">
                <button type="submit" class="btn-submit">Cập nhật</button>
                <button type="button" class="btn-cancel" onclick="window.location.href='index.php?act=/'">Hủy</button>
            </div>
        </form>
    </div>
</body>
</html>