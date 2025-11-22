<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="./views/quanly_HDV/css/danhsach_HDV.css" />
</head>
<body>
  <div class="header">
    <div>
      <h1>Danh sách Nhà cung cấp</h1>
    </div>
  </div>

  <!-- Search section -->
  <div class="search-section">
    <div class="search-group">
      <label for="quick-search">Tìm kiếm nhanh:</label>
      <input type="text" id="quick-search" placeholder="Nhập tên, email, số điện thoại...">
    </div>
    <select name="style" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" style="height: 38px; border-radius: 5px; border: 1px solid black;">
      <option value="all">Tất cả</option>
      <option value="Khách sạn">Khách sạn</option>
      <option value="Vận chuyển">Vận chuyển</option>
      <option value="Nhà hàng">Nhà hàng</option>
      <option value="Đặt vé">Đặt vé</option>
    </select>
    <button class="btn-reset" onclick="resetSearch()">
      <i class="fas fa-redo"></i> Đặt lại
    </button>
    <button class="btn-add-guide">
    <a href="index.php?act=supplier-add" style="color: white; text-decoration: none;">
        <i class="fas fa-plus"></i> Thêm hướng dẫn viên 
    </a>
    </button>
  </div>

<a href="index.php?act=supplier-add">+ Thêm nhà cung cấp</a>

<table border="1" cellpadding="6">
  <tr>
    <th>ID</th><th>Tên</th><th>Thể loại</th><th>Liên hệ</th><th>Chức năng</th>
  </tr>
  <?php foreach($suppliers as $s): ?>
  <tr>
    <td><?= $s['id'] ?></td>
    <td><?= htmlspecialchars($s['name']) ?></td>
    <td><?= $s['service_type'] ?></td>
    <td><?= htmlspecialchars($s['contact_name']." / ".$s['contact_phone']) ?></td>
    <td>
      <a href="index.php?act=supplier-contracts&supplier_id=<?= $s['id'] ?>">Danh sách HVD</a> |
      <a href="index.php?act=supplier-payments&supplier_id=<?= $s['id'] ?>">Thanh toán</a> |
      <a href="index.php?act=supplier-debts&supplier_id=<?= $s['id'] ?>">Công nợ</a> |
      <a href="index.php?act=supplier-edit&id=<?= $s['id'] ?>">Chỉnh sửa</a> |
      <a onclick="return confirm('Bạn chắc chắn muốn xóa?')" href="index.php?act=/supplier-delete&id=<?= $s['id'] ?>">Xóa</a>
    </td>
  </tr>
  <?php endforeach; ?>
</table>

</body>
</html>