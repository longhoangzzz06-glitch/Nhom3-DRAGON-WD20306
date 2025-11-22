<div class="container mt-4">
    <h3 class="fw-bold mb-3">Tạo nhắc hạn thanh toán</h3>

    <div class="card shadow">
        <div class="card-body">

            <form method="POST" action="index.php?controller=paymentReminder&action=store">
                
                <div class="mb-3">
                    <label class="form-label">Nhà cung cấp</label>
                    <input type="number" name="supplier_id" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Hợp đồng</label>
                    <input type="number" name="contract_id" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Số tiền</label>
                    <input type="number" name="amount" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Ngày đến hạn</label>
                    <input type="date" name="due_date" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Ghi chú</label>
                    <textarea name="note" class="form-control"></textarea>
                </div>

                <button class="btn btn-success">Tạo nhắc hạn</button>
                <a href="index.php?controller=paymentReminder&action=index"
                   class="btn btn-secondary">Hủy</a>
            </form>

        </div>
    </div>
</div>
