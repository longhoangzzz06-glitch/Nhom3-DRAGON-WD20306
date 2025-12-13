<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chỉnh sửa Nhà Cung Cấp</title>
    <link rel="stylesheet" href="./views/chung/css/form.css">
</head>
<body>

<div class="container mt-4">
    <div class="card shadow-sm">

        <div class="card-header bg-warning">
            <h4 class="m-0 text-dark">Chỉnh sửa Nhà Cung Cấp</h4>
        </div>

        <div class="card-body">
            <form method="POST"
                  enctype="multipart/form-data"
                  action="index.php?act=cap-nhat-supplier">

                <input type="hidden" name="id" value="<?= $supplier['id'] ?>">

                <div class="row mb-3">
                    <label class="col-md-3 col-form-label">Tên nhà cung cấp *</label>
                    <div class="col-md-9">
                        <input name="ten" class="form-control" required
                               value="<?= $supplier['ten'] ?>">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-md-3 col-form-label">Loại dịch vụ *</label>
                    <div class="col-md-9">
                        <input name="loai_dich_vu" class="form-control" required
                               value="<?= $supplier['loai_dich_vu'] ?>">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-md-3 col-form-label">Điện thoại</label>
                    <div class="col-md-9">
                        <input name="dien_thoai" class="form-control"
                               value="<?= $supplier['dien_thoai'] ?>">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-md-3 col-form-label">Email</label>
                    <div class="col-md-9">
                        <input type="email" name="email" class="form-control"
                               value="<?= $supplier['email'] ?>">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-md-3 col-form-label">Địa chỉ</label>
                    <div class="col-md-9">
                        <input name="dia_chi" class="form-control"
                               value="<?= $supplier['dia_chi'] ?>">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-md-3 col-form-label">Ghi chú</label>
                    <div class="col-md-9">
                        <textarea name="ghi_chu" class="form-control" rows="3"><?= $supplier['ghi_chu'] ?></textarea>
                    </div>
                </div>

                <div class="text-end">
                    <a href="index.php?act=quan-ly-supplier" class="btn btn-secondary">Quay lại</a>
                    <button type="submit" class="btn btn-warning px-4">
                        Cập nhật
                    </button>
                </div>

            </form>
        </div>

    </div>
</div>

</body>
</html>
