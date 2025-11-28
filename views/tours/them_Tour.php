<?php
// Định nghĩa module hiện tại
$currentModule = 'tour';

// Include dieu-huong
include './views/chung/dieu-huong.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Tour</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./views/tours/css/them_Tour.css" />
</head>
<body>
    <div class="content-wrapper">
        <div class="content-container">
            <div class="container">
                <h1>Thêm Tour mới</h1>
                <form action="index.php?act=them-tour" method="POST" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="ten">Tên Tour: <span style="color: red;">*</span></label>
                        <input type="text" id="ten" name="ten" required>
                    </div>

                    <div class="form-group">
                        <label for="danhMuc_id">Danh mục: <span style="color: red;">*</span></label>
                        <select id="danhMuc_id" name="danhMuc_id" required>
                            <option value="">-- Chọn danh mục --</option>
                        <?php
                        $danhMucList = (new TourController()) -> getAllDanhMucTour();
                        foreach ($danhMucList as $danhMuc): ?>
                            <option value="<?php echo $danhMuc['id']; ?>"><?php echo htmlspecialchars($danhMuc['ten']); ?></option>
                        <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="moTa">Mô tả: <span style="color: red;">*</span></label>
                        <textarea id="moTa" name="moTa" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="chinhSach_id">Chính sách:</label>
                        <select name="chinhSach_id" id="chinhSach_id">
                            <option value="">-- Chọn chính sách --</option>
                            <?php
                            $chinhSachList = (new TourController()) -> getAllChinhSach();
                            foreach ($chinhSachList as $chinhSach): ?>
                                <option value="<?php echo $chinhSach['id']; ?>"><?php echo htmlspecialchars($chinhSach['ten']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="ncc_id">Nhà cung cấp:</label>
                        <select name="ncc_id" id="ncc_id">
                            <option value="">-- Chọn nhà cung cấp --</option>
                            <?php
                            $nccList = (new TourController()) -> getAllNhaCungCap();
                            foreach ($nccList as $ncc): ?>
                                <option value="<?php echo $ncc['id']; ?>"><?php echo htmlspecialchars($ncc['ten']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="trangThai">Trạng thái:</label>
                        <select id="trangThai" name="trangThai">
                            <option value="Đang Hoạt Động">Đang Hoạt Động</option>
                            <option value="Không Hoạt Động">Không Hoạt Động</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="gia">Giá:</label>
                        <input type="number" id="gia" name="gia" required>
                    </div>

                    <div class="form-group">
                        <label for="tgBatDau">Thời gian bắt đầu:</label>
                        <input type="date" id="tgBatDau" name="tgBatDau" required>
                    </div>

                    <div class="form-group">
                        <label for="tgKetThuc">Thời gian kết thúc:</label>
                        <input type="date" id="tgKetThuc" name="tgKetThuc" required>
                    </div>

                    <div class="button-group">
                        <button type="submit" class="btn-submit">Thêm Tour</button>
                        <button type="button" class="btn-cancel" onclick="window.location.href='index.php?act=quan-ly-tours'">Hủy</button>
                    </div>
                </form>
            </div>
        </div>
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