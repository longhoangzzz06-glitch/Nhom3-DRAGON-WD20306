<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./views/chung/css/form.css" />
</head>
<body>

<div class="container mt-4">
    <div class="card shadow-sm">

        <div class="card-header bg-warning">
            <h4 class="m-0 text-dark">Chỉnh sửa Nhà Cung Cấp</h4>
        </div>

        <div class="card-body">
            <form method="POST" enctype="multipart/form-data" 
                  action="index.php?act=cap-nhat-supplier&id=" . $supplier['id']>

                <input type="hidden" name="id" value="<?= $supplier['id'] ?>">
                <!-- <input type="hidden" name="logo_old" value="<?= $supplier['logo'] ?>"> -->

                <div class="row mb-3">
                    <label class="col-md-3 col-form-label">Tên nhà cung cấp *</label>
                    <div class="col-md-9">
                        <input name="name" required class="form-control"
                               value="<?= $supplier['name'] ?>">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-md-3 col-form-label">Loại dịch vụ *</label>
                    <div class="col-md-9">
                        <input name="service_type" required class="form-control"
                               value="<?= $supplier['service_type'] ?>">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-md-3 col-form-label">Điện thoại</label>
                    <div class="col-md-9">
                        <input name="phone" class="form-control"
                               value="<?= $supplier['contact_phone'] ?>">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-md-3 col-form-label">Email</label>
                    <div class="col-md-9">
                        <input type="email" name="email" class="form-control"
                               value="<?= $supplier['contact_email'] ?>">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-md-3 col-form-label">Địa chỉ</label>
                    <div class="col-md-9">
                        <input name="address" class="form-control"
                               value="<?= $supplier['address'] ?>">
                    </div>
                </div>

                <!-- Logo -->
                <div class="row mb-3">
                    <label class="col-md-3 col-form-label">Logo</label>
                    <div class="col-md-9">
                        <input type="file" name="logo" class="form-control mb-2">

                        <!-- <?php if ($supplier['logo']): ?>
                            <img src="<?= $supplier['logo'] ?>" 
                                 style="width: 120px; border-radius: 6px; border: 1px solid #ddd;">
                        <?php endif; ?> -->
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-md-3 col-form-label">Ghi chú</label>
                    <div class="col-md-9">
                        <textarea name="note" class="form-control" rows="3"><?= $supplier['notes'] ?></textarea>
                    </div>
                </div>

                <div class="text-end">
                    <a href="index.php?act=supplier" class="btn btn-secondary">Quay lại</a>
                    <a href="index.php?act=cap-nhat-supplier&id= ' class="btn btn-warning px-4">Cập nhật</a>
                </div>

            </form>
        </div>

    </div>
</div>



</body>
</html>