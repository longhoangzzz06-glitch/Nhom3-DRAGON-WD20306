<h2>Thêm Nhà Cung Cấp</h2>
<form method="POST" action="index.php?controller=provider&action=store">

    <label>Tên nhà cung cấp</label>
    <input type="text" name="name" class="form-control" required>

    <label>Loại dịch vụ</label>
    <select name="type" class="form-control">
        <option value="hotel">Khách sạn</option>
        <option value="restaurant">Nhà hàng</option>
        <option value="transport">Vận chuyển</option>
        <option value="ticket">Vé</option>
        <option value="visa">Visa</option>
        <option value="insurance">Bảo hiểm</option>
        <option value="other">Khác</option>
    </select>

    <label>Địa chỉ</label>
    <input type="text" name="address" class="form-control">

    <label>Người liên hệ</label>
    <input type="text" name="contact_person" class="form-control">

    <label>Số điện thoại</label>
    <input type="text" name="phone" class="form-control">

    <label>Email</label>
    <input type="email" name="email" class="form-control">

    <label>Mô tả</label>
    <textarea name="description" class="form-control"></textarea>

    <label>Năng lực cung cấp</label>
    <input type="text" name="capacity" class="form-control">

    <br>
    <button class="btn btn-success">Lưu</button>
</form>
