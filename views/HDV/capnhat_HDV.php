<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>Sửa Hướng dẫn viên</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<link rel="stylesheet" href="./views/chung/css/form.css" />
</head>
<body>
<div class="content-wrapper">
    <h1>Sửa thông tin Hướng dẫn viên</h1>

    <?php if (!isset($hdv) || !$hdv): ?>
        <p style="color:red;">Không tìm thấy dữ liệu hướng dẫn viên!</p>
        <?php exit; ?>
    <?php endif; ?>

    <form action="index.php?act=cap-nhat-hdv&id=<?php echo $hdv['id']; ?>" method="POST" enctype="multipart/form-data">

        <input type="hidden" name="old_anh" value="<?php echo htmlspecialchars($hdv['anh'] ?? ''); ?>">
        <input type="hidden" name="taiKhoan_id" value="<?php echo htmlspecialchars($hdv['taiKhoan_id'] ?? ''); ?>">

        <h3>Thông tin tài khoản</h3>

        <div class="form-group">
            <label for="tenTk">Tên đăng nhập:</label>
            <!-- readonly vẫn gửi dữ liệu, disabled thì không -->
            <input type="text" id="tenTk" name="tenTk"
                   value="<?php echo htmlspecialchars($hdv['tenTaiKhoan'] ?? ''); ?>" readonly>
        </div>

        <div class="form-group" style="position:relative;">
            <label for="mk">Mật khẩu mới (để trống nếu không đổi):</label>
            <!-- KHÔNG prefill password từ DB -->
            <input type="password" id="mk" name="mk" style="padding-right:40px;">
            <i class="fa-solid fa-eye" id="togglePassword" style="position:absolute; right:10px; top:38px; cursor:pointer;"></i>
        </div>

        <!-- Ảnh -->
        <div class="form-group">
            <label for="anh">Ảnh (để trống nếu không thay đổi):</label>
            <?php if (!empty($hdv['anh'])): ?>
                <p style="margin:0 0 10px 0; font-size:14px;color:#666;">Ảnh hiện tại:</p>
                <img src="./uploads/img_HDV/<?php echo htmlspecialchars($hdv['anh']); ?>" alt="anh" class="photo-preview" />
            <?php endif; ?>
            <input type="file" id="anh" name="anh" accept="image/*">
            <p style="font-size:12px;color:#999;margin-top:5px;">Chỉ chọn file nếu muốn thay ảnh</p>
        </div>

        <!-- Thông tin HDV -->
        <div class="form-group">
            <label for="hoTen">Họ Tên: <span style="color:red">*</span></label>
            <input type="text" id="hoTen" name="hoTen" value="<?php echo htmlspecialchars($hdv['hoTen'] ?? ''); ?>" required>
        </div>

        <div class="form-group">
            <label for="ngaySinh">Ngày Sinh: <span style="color:red">*</span></label>
            <input type="date" id="ngaySinh" name="ngaySinh" value="<?php echo htmlspecialchars($hdv['ngaySinh'] ?? ''); ?>" required>
        </div>

        <div class="form-group">
            <label for="dienThoai">Số Điện Thoại: <span style="color:red">*</span></label>
            <input type="text" id="dienThoai" name="dienThoai" value="<?php echo htmlspecialchars($hdv['dienThoai'] ?? ''); ?>" required>
        </div>

        <div class="form-group">
            <label for="email">Email: <span style="color:red">*</span></label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($hdv['email'] ?? ''); ?>" required>
        </div>

        <div class="form-group">
            <label for="ngonNgu">Ngôn Ngữ:</label>
            <input type="text" id="ngonNgu" name="ngonNgu" value="<?php echo htmlspecialchars($hdv['ngonNgu'] ?? ''); ?>">
        </div>

        <div class="form-group">
            <label for="kinhNghiem">Kinh Nghiệm (năm):</label>
            <input type="number" id="kinhNghiem" name="kinhNghiem" value="<?php echo htmlspecialchars($hdv['kinhNghiem'] ?? '0'); ?>">
        </div>

        <div class="form-group">
            <label for="nhomHDV_id">Loại Nhóm:</label>
            <select name="nhomHDV_id" id="nhomHDV_id">
                <option value="">Chọn Loại Nhóm</option>
                <?php
                $nhomList = (new HDVController())->getAllNhomHDV();
                foreach ($nhomList as $nhom) {
                    $sel = ($hdv['nhomHDV_id'] == $nhom['id']) ? 'selected' : '';
                    echo '<option value="'.htmlspecialchars($nhom['id']).'" '.$sel.'>'.htmlspecialchars($nhom['ten']).'</option>';
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
                <option value="Đang hoạt động" <?php echo ($hdv['trangThai'] === 'Đang hoạt động') ? 'selected' : ''; ?>>Đang hoạt động</option>
                <option value="Không hoạt động" <?php echo ($hdv['trangThai'] === 'Không hoạt động') ? 'selected' : ''; ?>>Không hoạt động</option>
            </select>
        </div>

        <div class="button-group">
            <button type="submit" class="btn-submit">Cập nhật</button>
            <button type="button" class="btn-cancel" onclick="window.location.href='index.php?act=quan-ly-hdv'">Hủy</button>
        </div>

    </form>
</div>

<script>
    // toggle show/hide password
    const mkInput = document.getElementById("mk");
    const togglePw = document.getElementById("togglePassword");
    if (togglePw && mkInput) {
        togglePw.classList.add('fa-eye');
        togglePw.addEventListener('click', () => {
            const type = mkInput.getAttribute("type") === "password" ? "text" : "password";
            mkInput.setAttribute("type", type);
            togglePw.classList.toggle("fa-eye");
            togglePw.classList.toggle("fa-eye-slash");
        });
    }
</script>
</body>
</html>
