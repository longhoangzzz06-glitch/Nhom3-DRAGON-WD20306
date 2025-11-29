# 📌 Chức Năng Highlight Menu Theo Trang

## 🎯 Mục Đích
Highlight (làm nổi bật) menu item tương ứng khi người dùng ở trang đó, giúp người dùng biết mình đang ở đâu trong hệ thống.

---

## ⚙️ Cách Hoạt Động

### 1️⃣ **Lấy Route Hiện Tại**
```javascript
const urlParams = new URLSearchParams(window.location.search);
const currentAct = urlParams.get('act') || '/';
```
- Lấy parameter `act` từ URL (ví dụ: `index.php?act=quan-ly-hdv`)
- Nếu không có `act`, mặc định là `/` (trang chủ)

### 2️⃣ **Mapping Route → Menu Item**
```javascript
const routeToMenuMap = {
  'quan-ly-hdv': 'nav-hdv',           // Tất cả route HDV → nav-hdv
  'view-them-hdv': 'nav-hdv',
  'them-hdv': 'nav-hdv',
  ...
  'quan-ly-tours': 'nav-tour',        // Tất cả route Tours → nav-tour
  'view-them-tour': 'nav-tour',
  ...
  'quan-ly-booking': 'nav-booking',   // Tất cả route Booking → nav-booking
  ...
}
```
- Map tất cả routes liên quan đến cùng một module đến **một menu item**
- Ví dụ: Dù bạn ở `them-hdv`, `xoa-hdv` hay `quan-ly-hdv`, menu "Quản lý Hướng dẫn viên" vẫn highlight

### 3️⃣ **Xóa Active Class Cũ**
```javascript
document.querySelectorAll('.nav-item .nav-link').forEach(link => {
  link.classList.remove('active');
});
```
- Loại bỏ class `active` từ tất cả menu items cũ

### 4️⃣ **Thêm Active Class Mới**
```javascript
const menuItem = document.getElementById(menuId);
const navLink = menuItem.querySelector('.nav-link');
navLink.classList.add('active');
```
- Tìm menu item cần highlight (dựa trên `menuId`)
- Thêm class `active` vào nó

---

## 🔍 Ví Dụ Thực Tế

### Kịch Bản 1: Người dùng vào trang danh sách HDV
```
URL: index.php?act=quan-ly-hdv

→ currentAct = 'quan-ly-hdv'
→ menuId = routeToMenuMap['quan-ly-hdv'] = 'nav-hdv'
→ Thêm class 'active' vào phần tử id='nav-hdv'
→ Menu "Quản lý Hướng dẫn viên" được highlight ✅
```

### Kịch Bản 2: Người dùng vào trang thêm HDV
```
URL: index.php?act=view-them-hdv

→ currentAct = 'view-them-hdv'
→ menuId = routeToMenuMap['view-them-hdv'] = 'nav-hdv'
→ Menu "Quản lý Hướng dẫn viên" vẫn highlight ✅
```

### Kịch Bản 3: Người dùng vào trang Tours
```
URL: index.php?act=quan-ly-tours

→ currentAct = 'quan-ly-tours'
→ menuId = routeToMenuMap['quan-ly-tours'] = 'nav-tour'
→ Menu "Quản lý Tour" được highlight ✅
```

---

## 🎨 CSS Styling

Để `highlight` hiển thị, bạn cần CSS cho class `active`:

```css
/* Trong adminlte.css */
.nav-link.active {
  background-color: rgba(255, 255, 255, 0.1) !important;
  color: #fff !important;
  font-weight: 600;
}
```

AdminLTE đã có mặc định, nên menu sẽ tự highlight khi có class `active`.

---

## 📊 Sơ Đồ Luồng

```
User vào index.php?act=XXX
        ↓
DOMContentLoaded Event
        ↓
Lấy act từ URL
        ↓
Tìm menuId từ routeToMenuMap
        ↓
Xóa class active từ tất cả menu items
        ↓
Thêm class active vào menu item tương ứng
        ↓
Menu được highlight 🌟
```

---

## 💡 Ưu Điểm

✅ **Tự động** - Không cần thêm code ở mỗi trang  
✅ **Nhất quán** - Cùng menu highlight dù ở trang con hay trang chính  
✅ **Dễ mở rộng** - Chỉ cần thêm route vào `routeToMenuMap`  
✅ **Hiệu năng tốt** - Chạy sau khi DOM load xong  

---

## 🔧 Cách Mở Rộng

Nếu thêm menu mới, chỉ cần:

1. Thêm `id` vào menu item trong HTML:
```html
<li class="nav-item" id="nav-new-module">
  <a href="index.php?act=quan-ly-new" class="nav-link">
    <i class="nav-icon bi bi-star"></i>
    <p>Quản lý Module Mới</p>
  </a>
</li>
```

2. Thêm mapping vào `routeToMenuMap`:
```javascript
'quan-ly-new': 'nav-new-module',
'view-them-new': 'nav-new-module',
```

Xong! ✨
