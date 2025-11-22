<h2>Sửa Nhà Cung Cấp</h2>

<form method="POST" action="index.php?controller=provider&action=update">
    <input type="hidden" name="id" value="<?= $provider['id'] ?>">

    <label>Tên nhà cung cấp</label>
    <input type="text" name="name" value="<?= $provider['name'] ?>" class="form-control">

    <label>Loại</label>
    <select name="type" class="form-control">
        <option <?= $provider['type']=='hotel'?'selected':'' ?> value="hotel">Khách sạn</option>
        <option <?= $provider['type']=='restaurant'?'selected':'' ?> value="restaurant">Nhà hàng</option>
        <option <?= $provider['type']=='transport'?'selected':'' ?> value="transport">Vận chuyển</option>
        <option <?= $provider['type']=='ticket'?'selected':'' ?> value="ticket">Vé</option>
        <option <?= $provider['type']=='visa'?'selected':'' ?> value="visa">Visa</option>
        <option <?= $provider['type']=='insurance'?'selected':'' ?> value="insurance">Bảo hiểm</option>
        <option <?= $provider['type']=='other'?'selected':'' ?> value="other">Khác</option>
    </select>

    <label>Địa chỉ</label>
    <input type="text" name="address" value="<?= $provider['address'] ?>" class="form-control">

    <label>Người liên hệ</label>
    <input type="text" name="contact_person" value="<?= $provider['contact_person'] ?>" class="form-control">

    <label>Số điện thoại</label>
    <input type="text" name="phone" value="<?= $provider['phone'] ?>" class="form-control">

    <label>Email</label>
    <input type="email" name="email" value="<?= $provider['email'] ?>" class="form-control">

    <label>Mô tả</label>
    <textarea name="description" class="form-control"><?= $provider['description'] ?></textarea>

    <label>Năng lực cung cấp</label>
    <input type="text" name="capacity" value="<?= $provider['capacity'] ?>" class="form-control">

    <br>
    <button class="btn btn-success">Cập nhật</button>
</form>
