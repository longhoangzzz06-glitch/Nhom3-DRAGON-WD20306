            <div class="form-group">
                <form action="" method="POST">
                <label for="ncc_id">Chọn nhà cung cấp để thêm:</label>
                    <select id="ncc_id">
                        <option value="">--Chọn nhà cung cấp--</option>
                        <?php foreach ($allNcc as $ncc): ?>
                            <option value="<?= $ncc['id'] ?>"><?= $ncc['ten'] ?> (<?= $ncc['dvCungCap'] ?>)</option>
                        <?php endforeach; ?>
                    </select>
                    <div style="display: flex">
                    <button type="button" onclick="addNccToTour(<?= $tour['id'] ?>)" class="btn-submit" style="margin: 5px 0;">
                        Thêm NCC vào Tour
                    </button>
                    </div>
                </form>
            </div>

            <h4>Nhà cung cấp hiện tại của tour:</h4>
            <ul>
            <?php foreach ($selectedNcc as $ncc): ?>
                <li style="display: flex; justify-content: space-between; align-items: center; max-width: 1400px; margin-bottom: 5px; border-bottom: 1px solid #ccc; padding-bottom: 5px;">
                    <?= $ncc['ten'] ?> (<?= $ncc['dvCungCap'] ?>)
                    <a href="index.php?&act=xoaNccKhoiTour&tour_id=<?= $tour['id'] ?>&ncc_id=<?= $ncc['id'] ?>"
                    onclick="return confirm('Bạn có chắc muốn xóa NCC này khỏi tour?');">
                    <i class="fa fa-trash" style="color: red; margin-right: 30px;"></i>
                    </a>                        
                </li>
            <?php endforeach; ?>
            </ul>

                echo "<pre>";
    echo "LỖI XẢY RA:\n";
    print_r($e->getMessage());
    echo "\n\nSTACK TRACE:\n";
    print_r($e->getTraceAsString());
    echo "</pre>";
    exit();
            '/', 'trang-chu' => (new HDVController())->danhSach(),

        /* Trang quản lý hướng dẫn viên */
        // Hiển thị danh sách hướng dẫn viên
        'quan-ly-hdv' => (new HDVController())->danhSach(),
        // Xử lý thêm hướng dẫn viên
        'view-them-hdv' => (new HDVController())->viewThemHDV(),
        'them-hdv' => (new HDVController())->themHDV($_POST),
        // Xử lý xóa hướng dẫn viên
        'xoa-hdv' => (new HDVController())->xoaHDV($_GET['id']),
        // Xử lý cập nhật hướng dẫn viên
        'view-cap-nhat-hdv' => (new HDVController())->viewCapNhatHDV($_GET['id']),
        'cap-nhat-hdv' => (new HDVController())->capNhatHDV($_GET['id'], $_POST),
        /* ==================== AUTH ==================== */

// Giao diện đăng ký
'register' => (new HdvAuthController())->registerForm(),
// Xử lý đăng ký
'post-register' => (new HdvAuthController())->register(),

// Giao diện đăng nhập
'login' => (new HdvAuthController())->loginForm(),

// Đăng xuất
'logout' => (new HdvAuthController())->logout(),


        /* Trang quản lý Tours */
        // Hiển thị danh sách Tours
        'quan-ly-tours' => (new TourController())->danhSachTour(),
        // Xử lý thêm Tours
        'view-them-tour' => (new TourController())->viewThemTour(),
        'them-tour' => (new TourController())->themTour($_POST),
        // Xử lý xóa Tours
        'xoa-tour' => (new TourController())->xoaTour($_GET['id']),
        // Xử lý cập nhật Tours
        'view-cap-nhat-tour' => (new TourController())->viewCapNhatTour($_GET['id']),
        'cap-nhat-tour' => (new TourController())->capNhatTour($_GET['id'], $_POST),

        /* Trang quản lý Booking */
        // Hiển thị danh sách Booking
        'quan-ly-booking' => (new BookingController())->danhSachBooking(),
        // Xử lý xóa Booking
        'xoa-booking' => (new BookingController())->delete(),
        // Xử lý cập nhật Booking
        'view-cap-nhat-booking' => (new BookingController())->edit(),
        'cap-nhat-booking' => (new BookingController())->update(),
        // Xử lý đặt booking
        'view-dat-booking' => (new BookingController())->viewDatBooking(),
        'store-booking' => (new BookingController())->datBooking(),
        'dat-booking' => (new BookingController())->datBooking(),
        // API Check-in
        'api-check-in' => (new BookingController())->apiCheckIn(),
        'api-get-customers' => (new BookingController())->apiGetCustomersList(),
        // API Add/Delete Customer
        'api-add-customer' => (new BookingController())->apiAddCustomer(),
        'api-add-customer-link' => (new BookingController())->apiAddCustomerLink(),
        'api-delete-customer' => (new BookingController())->apiDeleteCustomer(),
        /* Trang quản lý Supplier */
        // Hiển thị danh sách Supplier
        'quan-ly-supplier' => (new SupplierController())->index(),

        // Trang thêm Supplier
        'view-them-supplier' => (new SupplierController())->create(),
        'them-supplier' => (new SupplierController())->store($_POST),

        // Trang cập nhật Supplier
        'view-cap-nhat-supplier' => (new SupplierController())->edit($_GET['id']),
        'cap-nhat-supplier' => (new SupplierController())->update($_GET['id'], $_POST),

        // Xóa Supplier
        'xoa-supplier' => (new SupplierController())->delete($_GET['id']),
        /* Trang quản lý Hợp đồng */
        'quan-ly-hopdong' => (new HopDongController())->index(),
        'view-them-hopdong' => (new HopDongController())->create(),
        'them-hopdong' => (new HopDongController())->store($_POST),
        'view-cap-nhat-hopdong' => (new HopDongController())->edit($_GET['id']),
        'cap-nhat-hopdong' => (new HopDongController())->update($_GET['id'], $_POST),
        'xoa-hopdong' => (new HopDongController())->delete($_GET['id']),

        /* Trang quản lý Công nợ */
        'quan-ly-congno' => (new CongNoController())->index(),
        'view-them-congno' => (new CongNoController())->create(),
        'them-congno' => (new CongNoController())->store($_POST),
        'view-cap-nhat-congno' => (new CongNoController())->edit($_GET['id']),
        'cap-nhat-congno' => (new CongNoController())->update($_GET['id'], $_POST),
        'xoa-congno' => (new CongNoController())->delete($_GET['id']),

        /* Trang quản lý Đánh giá NCC */
        'quan-ly-danhgia' => (new DanhGiaNCCController())->index(),
        'view-them-danhgia' => (new DanhGiaNCCController())->create(),
        'them-danhgia' => (new DanhGiaNCCController())->store($_POST),
        'view-cap-nhat-danhgia' => (new DanhGiaNCCController())->edit($_GET['id']),
        'cap-nhat-danhgia' => (new DanhGiaNCCController())->update($_GET['id'], $_POST),
        'xoa-danhgia' => (new DanhGiaNCCController())->delete($_GET['id']),

        /* Trang Báo cáo Tài chính */
        'bao-cao-taichinh' => (new TaiChinhTourController())->baoCao(),
              require_once './commons/env.php'; // Khai báo biến môi trường
      require_once './commons/function.php'; // Hàm hỗ trợ

      // Require toàn bộ file Controllers
      require_once './controllers/HDVController.php';
      require_once './controllers/TourController.php';
      require_once './controllers/BookingController.php';
      require_once './controllers/SupplierController.php';
      require_once './controllers/HopDongController.php';
      require_once './controllers/CongNoController.php';
      require_once './controllers/DanhGiaNCCController.php';
      require_once './controllers/TaiChinhTourController.php';
      require_once './controllers/HdvAuthController.php';


      // Require toàn bộ file Models
      require_once './models/HDVModel.php';
      require_once './models/TourModel.php';
      require_once './models/BookingModel.php';
      require_once './models/SupplierModel.php';
      
      // Require toàn bộ file Models mới
      require_once './models/HopDong.php';
      require_once './models/CongNo.php';
      require_once './models/DanhGiaNCC.php';
      require_once './models/TaiChinhTour.php';
      require_once './models/HdvAuthModel.php';

