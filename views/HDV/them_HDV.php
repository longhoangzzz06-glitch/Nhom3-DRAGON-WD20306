<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Hướng dẫn viên</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./views/chung/css/form.css"/>
</head>
<body>
    <div class="content-wrapper">
        <div class="content-container">
            <div class="container">
                <h1>Thêm Hướng dẫn viên mới</h1>

        <form action="index.php?act=them-hdv" method="POST" enctype="multipart/form-data">

            <!-- ẢNH -->
            <div class="form-group">
                <label for="anh">Ảnh: <span style="color: red;">*</span></label>
                <div class="file-input-wrapper">
                    <input type="file" id="anh" name="anh" accept="image/*" required>
                    <label for="anh" class="file-input-label" id="anhLabel">
                        <i class="fas fa-cloud-upload-alt"></i> Chọn ảnh
                    </label>
                </div>
                <p style="font-size: 12px; color: #999; margin-top: 5px;">Chỉ chấp nhận file ảnh (jpg, jpeg, png, gif, webp)</p>
            </div>

            <!-- TÀI KHOẢN -->
            <h3 style="margin-top: 25px;">Thông tin tài khoản</h3>

            <div class="form-group">
                <label for="tenTk">Tên đăng nhập: <span style="color: red;">*</span></label>
                <input type="text" id="tenTk" name="tenTk" required>
            </div>

            <div class="form-group">
                <label for="mk">Mật khẩu: <span style="color: red;">*</span></label>
                <input type="password" id="mk" name="mk" required>
            </div>

            <!-- THÔNG TIN HDV -->
            <h3 style="margin-top: 25px;">Thông tin hướng dẫn viên</h3>

            <div class="form-group">
                <label for="hoTen">Họ Tên: <span style="color: red;">*</span></label>
                <input type="text" id="hoTen" name="hoTen" required>
            </div>

            <div class="form-group">
                <label for="ngaySinh">Ngày Sinh: <span style="color: red;">*</span></label>
                <input type="date" id="ngaySinh" name="ngaySinh" required>
            </div>

            <div class="form-group">
                <label for="dienThoai">Số Điện Thoại: <span style="color: red;">*</span></label>
                <input type="text" id="dienThoai" name="dienThoai" required>
            </div>

            <div class="form-group">
                <label for="email">Email: <span style="color: red;">*</span></label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="ngonNgu">Ngôn Ngữ:</label>
                <input type="text" id="ngonNgu" name="ngonNgu">
            </div>

            <div class="form-group">
                <label for="kinhNghiem">Kinh Nghiệm (năm):</label>
                <input type="number" id="kinhNghiem" name="kinhNghiem">
            </div>

            <div class="form-group">
                <label for="nhomHDV_id">Loại Nhóm: <span style="color: red;">*</span></label>
                <select name="nhomHDV_id" id="nhomHDV_id" required>
                    <option value="">Chọn Loại Nhóm</option>
                    <?php
                        $nhomList = (new HDVController())->getAllNhomHDV();
                        foreach ($nhomList as $nhom) {
                            echo '<option value="' . htmlspecialchars($nhom['id']) . '">' . htmlspecialchars($nhom['ten']) . '</option>';
                        }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="sucKhoe">Tình Trạng Sức Khỏe:</label>
                <select name="sucKhoe" id="sucKhoe">
                    <option value="Tốt">Tốt</option>
                    <option value="Khá">Khá</option>
                    <option value="Trung bình">Trung bình</option>
                    <option value="Kém">Kém</option>
                </select>
            </div>

            <div class="form-group">
                <label for="trangThai">Trạng Thái:</label>
                <select id="trangThai" name="trangThai">
                    <option value="Đang Hoạt Động">Đang Hoạt Động</option>
                    <option value="Không Hoạt Động">Không Hoạt Động</option>
                </select>
            </div>

            <div class="button-group">
                <button type="submit" class="btn-submit">Thêm Hướng dẫn viên</button>
                <button type="button" class="btn-cancel" onclick="window.location.href='index.php?act=/'">Hủy</button>
            </div>
        </form>
        </div>
        </div>
    </div>

    <script>
        const photoInput = document.getElementById('anh');
        const photoLabel = document.getElementById('anhLabel');

        photoInput.addEventListener('change', function () {
            if (this.files && this.files[0]) {
                const fileName = this.files[0].name;
                photoLabel.innerHTML = `<i class="fas fa-check-circle"></i> ${fileName}`;
                photoLabel.classList.add('has-file');
            }
        });
    </script>
</body>
</html>
