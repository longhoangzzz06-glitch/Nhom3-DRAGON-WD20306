<div class="container mt-4">
    <h3 class="fw-bold mb-3">Thêm hợp đồng mới</h3>

    <div class="card shadow-sm">
        <div class="card-body">

            <form method="POST" enctype="multipart/form-data"
                  action="index.php?controller=contract&action=store">

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Nhà cung cấp</label>
                        <input type="text" name="supplier_id" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Số hợp đồng</label>
                        <input type="text" name="contract_number" class="form-control" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Ngày bắt đầu</label>
                        <input type="date" name="start_date" class="form-control" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Ngày kết thúc</label>
                        <input type="date" name="end_date" class="form-control" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Hạn thanh toán</label>
                        <input type="date" name="payment_due" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tệp hợp đồng (PDF/IMG)</label>
                    <input type="file" name="file" class="form-control">
                </div>

                <div class="d-flex justify-content-end">
                    <a href="index.php?controller=contract&action=index" class="btn btn-secondary me-2">Hủy</a>
                    <button class="btn btn-primary">Lưu hợp đồng</button>
                </div>

            </form>

        </div>
    </div>
</div>
