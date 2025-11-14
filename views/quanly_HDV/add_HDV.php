<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Hướng dẫn viên</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./views/quanly_HDV/css/add_HDV.css" />
</head>
<body>
    <div class="container">
        <h1>Thêm Hướng dẫn viên mới</h1>

        <form action="index.php?act=them-hdv" method="POST" enctype="multipart/form-data">

            <div class="form-group">
                <label for="photo">Ảnh: <span style="color: red;">*</span></label>
                <div class="file-input-wrapper">
                    <input type="file" id="photo" name="photo" accept="image/*" required>
                    <label for="photo" class="file-input-label" id="photoLabel">
                        <i class="fas fa-cloud-upload-alt"></i> Chọn ảnh
                    </label>
                </div>
                <p style="font-size: 12px; color: #999; margin-top: 5px;">Chỉ chấp nhận file ảnh (jpg, jpeg, png, gif, webp)</p>
            </div>            

            <div class="form-group">
                <label for="full_name">Họ Tên: <span style="color: red;">*</span></label>
                <input type="text" id="full_name" name="full_name" required>
            </div>

            <div class="form-group">
                <label for="birth_date">Ngày Sinh: <span style="color: red;">*</span></label>
                <input type="date" id="birth_date" name="birth_date" required>
            </div>

            <div class="form-group">
                <label for="phone">Số Điện Thoại: <span style="color: red;">*</span></label>
                <input type="text" id="phone" name="phone" required>
            </div>

            <div class="form-group">
                <label for="email">Email: <span style="color: red;">*</span></label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="languages">Ngôn Ngữ:</label>
                <input type="text" id="languages" name="languages">
            </div>

            <div class="form-group">
                <label for="experience_years">Kinh Nghiệm (năm):</label>
                <input type="number" id="experience_years" name="experience_years">
            </div>

            <div class="form-group">
                <label for="health_status">Tình Trạng Sức Khỏe:</label>
                <input type="text" id="health_status" name="health_status">
            </div>

            <div class="form-group">
                <label for="status">Trạng Thái:</label>
                <select id="status" name="status">
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

    <script>
        const photoInput = document.getElementById('photo');
        const photoLabel = document.getElementById('photoLabel');
        const birthDatePicker = document.getElementById('birth_date_picker');
        const birthDateHidden = document.getElementById('birth_date_hidden');

        photoInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const fileName = this.files[0].name;
                photoLabel.innerHTML = `<i class="fas fa-check-circle"></i> ${fileName}`;
                photoLabel.classList.add('has-file');
            }
        });

        birthDatePicker.addEventListener('change', function() {
            if (this.value) {
                const [year, month, day] = this.value.split('-');
                birthDateHidden.value = `${day}/${month}/${year}`;
            }
        });
    </script>
</body>
</html>