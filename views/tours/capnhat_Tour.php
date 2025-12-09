<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Tour</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./views/chung/css/form.css" />
</head>
<body>
    <div class="content-wrapper">
        <div class="content-container">
            <div class="container">
                <h1>Sửa thông tin Tour</h1>
    
    <?php
    if (!isset($tour) || !$tour) {
        echo "<p style='color: red;'>Không tìm thấy dữ liệu tour!</p>";
        exit;
    }
    ?>
        <form action="index.php?act=cap-nhat-tour&id=<?php echo $tour['id']; ?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="ten">Tên Tour: <span style="color: red;">*</span></label>
                <input type="text" id="ten" name="ten" value="<?php echo htmlspecialchars($tour['ten'] ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label for="danhMuc_id">Danh mục: <span style="color: red;">*</span></label>
                <select id="danhMuc_id" name="danhMuc_id" required>
                    <option value="">-- Chọn danh mục --</option>
                <?php
                $danhMucList = (new TourController()) -> getAllDanhMucTour();
                foreach ($danhMucList as $danhMuc): ?>
                    <option value="<?php echo $danhMuc['id']; ?>" <?php echo ($tour['danhMuc_id'] == $danhMuc['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($danhMuc['ten']);?></option>
                <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="moTa">Mô tả: <span style="color: red;">*</span></label>
                <textarea id="moTa" name="moTa" required><?php echo htmlspecialchars($tour['moTa'] ?? ''); ?></textarea>
            </div>

            <div class="form-group">
                <label for="chinhSach">Chính sách:</label>
                <textarea id="chinhSach" name="chinhSach" rows="10" cols="50"><?php echo htmlspecialchars($tour['chinhSach'] ?? '');?></textarea>
            </div>

            <div class="form-group">
                <label for="gia">Giá:</label>
                <input type="number" id="gia" name="gia" value="<?php echo htmlspecialchars($tour['gia'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label for="trangThai">Trạng thái:</label>
                <select id="trangThai" name="trangThai">
                    <option value="Đang Hoạt Động">Đang Hoạt Động</option>
                    <option value="Không Hoạt Động">Không Hoạt Động</option>
                </select>
            </div>

            <div class="button-group">
                <button type="submit" class="btn-submit">Cập nhật</button>
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

    function addNccToTour(tourId) {
        const nccSelect = document.getElementById('ncc_id');
        const nccId = nccSelect.value;

        if (!nccId) {
            alert('Vui lòng chọn nhà cung cấp để thêm.');
            return;
        }

        window.location.href = `index.php?&act=them-ncc-vao-tour&tour_id=${tourId}&ncc_id=${nccId}`;
    }
    </script>
</body>
</html>