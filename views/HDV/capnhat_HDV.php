<?php
// Định nghĩa module hiện tại
$currentModule = 'hdv';

// Include sidedieu-huongbar
include './views/chung/dieu-huong.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./views/HDV/css/capnhat_HDV.css" />
</head>
<body>
  <div class="content-wrapper">    
    <h1>Sửa thông tin Hướng dẫn viên</h1>
    
    <?php
    if (!isset($hdv) || !$hdv) {
        echo "<p style='color: red;'>Không tìm thấy dữ liệu hướng dẫn viên!</p>";
        exit;
    }
    ?>

    <form action="index.php?act=cap-nhat-hdv&id=<?php echo $hdv['id']; ?>" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="anh">Ảnh (để trống nếu không thay đổi):</label>
            <?php if ($hdv['anh']): ?>
                <p style="margin: 0 0 10px 0; font-size: 14px; color: #666;">Ảnh hiện tại:</p>
                <img src="./uploads/img_HDV/<?php echo htmlspecialchars($hdv['anh']); ?>" alt="Ảnh HDV" class="photo-preview">
                <input type="hidden" name="old_anh" value="<?php echo htmlspecialchars($hdv['anh']); ?>">
            <?php endif; ?>
            <input type="file" id="anh" name="anh" accept="image/*">
            <p style="font-size: 12px; color: #999; margin-top: 5px;">Chỉ chọn file nếu muốn thay đổi ảnh</p>
        </div>
        
        <div class="form-group">
            <label for="hoTen">Họ Tên: <span style="color: red;">*</span></label>
            <input type="text" id="hoTen" name="hoTen" value="<?php echo htmlspecialchars($hdv['hoTen']); ?>" required>
        </div>

        <div class="form-group">
            <label for="ngaySinh">Ngày Sinh: <span style="color: red;">*</span></label>
            <input type="date" id="ngaySinh" name="ngaySinh" value="<?php echo $hdv['ngaySinh']; ?>" required>
        </div>

        <div class="form-group">
            <label for="dienThoai">Số Điện Thoại: <span style="color: red;">*</span></label>
            <input type="text" id="dienThoai" name="dienThoai" value="<?php echo htmlspecialchars($hdv['dienThoai']); ?>" required>
        </div>

        <div class="form-group">
            <label for="email">Email: <span style="color: red;">*</span></label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($hdv['email']); ?>" required>
        </div>

        <div class="form-group">
            <label for="ngonNgu">Ngôn Ngữ:</label>
            <input type="text" id="ngonNgu" name="ngonNgu" value="<?php echo htmlspecialchars($hdv['ngonNgu'] ?? ''); ?>">
        </div>

        <div class="form-group">
            <label for="kinhNghiem">Kinh Nghiệm (năm):</label>
            <input type="number" id="kinhNghiem" name="kinhNghiem" value="<?php echo htmlspecialchars($hdv['kinhNghiem'] ?? ''); ?>">
        </div>

        <div class="form-group">
            <label for="nhomHDV_id">Loại Nhóm:</label>
            <select name="nhomHDV_id" id="nhomHDV_id">
                <option value="">Chọn Loại Nhóm</option>
                    <?php
                    // Query danh sách nhóm HDV từ DB
                        $nhomList = (new HDVController())->getAllNhomHDV();
                        
                        foreach ($nhomList as $nhom) {
                            echo '<option value="' . htmlspecialchars($nhom['id']) . '" ' . (($hdv['nhomHDV_id'] == $nhom['id']) ? 'selected' : '') . '>' . htmlspecialchars($nhom['ten']) . '</option>';
                        }
                    ?>
            </select>
        </div>

        <div class="form-group">
            <label for="sucKhoe">Tình Trạng Sức Khỏe:</label>
            <select name="sucKhoe" id="sucKhoe">
                <option value="Tốt" <?php echo ($hdv['sucKhoe'] === 'Tốt') ? 'selected' : ''; ?>>Tốt</option>
                <option value="Khá" <?php echo ($hdv['sucKhoe'] === 'Khá') ? 'selected' : ''; ?>>Khá</option>
                <option value="Trung bình" <?php echo ($hdv['sucKhoe'] === 'Trung bình') ? 'selected' : ''; ?>>Trung bình</option>
                <option value="Kém" <?php echo ($hdv['sucKhoe'] === 'Kém') ? 'selected' : ''; ?>>Kém</option>
            </select>
        </div>

        <div class="form-group">
            <label for="trangThai">Trạng Thái:</label>
            <select id="trangThai" name="trangThai">
                <option value="Đang Hoạt Động" <?php echo ($hdv['trangThai'] === 'Đang Hoạt Động') ? 'selected' : ''; ?>>Đang Hoạt Động</option>
                <option value="Không Hoạt Động" <?php echo ($hdv['trangThai'] === 'Không Hoạt Động') ? 'selected' : ''; ?>>Không Hoạt Động</option>
            </select>
        </div>

        <div class="button-group">
            <button type="submit" class="btn-submit">Cập nhật</button>
            <button type="button" class="btn-cancel" onclick="window.location.href='index.php?act=quan-ly-hdv'">Hủy</button>
        </div>
    </form>
</div>    
</body>
</html>