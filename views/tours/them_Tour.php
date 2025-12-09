<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Tour</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./views/chung/css/form.css" />
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
                        <label for="chinhSach">Chính sách:</label>
                        <textarea id="chinhSach" name="chinhSach"></textarea>
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

                    <div class="button-group">
                        <button type="submit" class="btn-submit">Thêm Tour</button>
                        <button type="button" class="btn-cancel" onclick="window.location.href='index.php?act=quan-ly-tours'">Hủy</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // ==================== FORM VALIDATION ====================
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            
            form.addEventListener('submit', function(e) {
                // Basic validation can be added here if needed
            });
        });
    </script>
</body>
</html>