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
        <div class="card-header bg-primary text-white">
            <h4 class="m-0">Thêm Nhà Cung Cấp</h4>
        </div>

        <div class="card-body">
            <form method="POST" enctype="multipart/form-data" action="index.php?act=them-supplier">

                <div class="row mb-3">
                    <label class="col-md-3 col-form-label">Tên nhà cung cấp *</label>
                    <div class="col-md-9">
                        <input name="ten" required class="form-control" placeholder="VD: Khách sạn Golden Dragon">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-md-3 col-form-label">Loại dịch vụ *</label>
                    <div class="col-md-9">
                        <input name="loai_dich_vu" required class="form-control" placeholder="VD: Khách sạn, Nhà hàng, Xe du lịch...">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-md-3 col-form-label">Điện thoại</label>
                    <div class="col-md-9">
                        <input name="dien_thoai" class="form-control" placeholder="VD: 0988 123 456">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-md-3 col-form-label">Email</label>
                    <div class="col-md-9">
                        <input name="email" type="email" class="form-control" placeholder="VD: supplier@gmail.com">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-md-3 col-form-label">Địa chỉ</label>
                    <div class="col-md-9">
                        <input name="dia_chi" class="form-control" placeholder="Địa chỉ cụ thể...">
                    </div>
                </div>


                <div class="row mb-3">
                    <label class="col-md-3 col-form-label">Ghi chú</label>
                    <div class="col-md-9">
                        <textarea name="ghi_chu" class="form-control" rows="3" placeholder="Ghi chú thêm..."></textarea>
                    </div>
                </div>

                <div class="text-end">
                    <a href="index.php?act=quan-ly-supplier" class="btn btn-secondary">Hủy</a>
                    <button type="submit" class="btn btn-primary px-4">Lưu</button>
                </div>

            </form>
        </div>
    </div>
</div>

</body>
</html>