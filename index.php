<?php 
// Require toàn bộ các file khai báo môi trường, thực thi,...(không require view)

// Require file Common
require_once './commons/env.php'; // Khai báo biến môi trường
require_once './commons/function.php'; // Hàm hỗ trợ

// Require toàn bộ file Controllers
require_once './controllers/HDVController.php'; 
require_once './controllers/FeedbackController.php';
require_once './controllers/SupplierController.php';

// Require toàn bộ file Models
require_once './models/HDVModel.php';
require_once './models/Feedback.php';
require_once './models/supplier/Supplier.php';
require_once './models/supplier/SupplierContract.php';
require_once './models/supplier/SupplierDebt.php';
require_once './models/supplier/SupplierPayment.php';
require_once './models/supplier/SupplierQuote.php';

// Route
$act = $_GET['act'] ?? '/';
$db = connectDB();


// Để bảo bảo tính chất chỉ gọi 1 hàm Controller để xử lý request thì mình sử dụng match

match ($act) {
    // Trang chủ
    'home' => (new HomeController())->home(),
    // Trang quản lý hướng dẫn viên
    // Hiển thị danh sách hướng dẫn viên
    '/'=> (new HDVController())->DanhSach(),
    // Xử lý thêm hướng dẫn viên
    'view-them-hdv'=> (new HDVController())->viewThemHDV(),
    'them-hdv'=> (new HDVController())->addHDV($_POST),
    // Xử lý xóa hướng dẫn viên
    'xoa-hdv'=> (new HDVController())->deleteHDV($_GET['id']),
    // Xử lý cập nhật hướng dẫn viên
    'view-cap-nhat-hdv'=> (new HDVController())->viewCapNhatHDV($_GET['id']),
    'cap-nhat-hdv'=> (new HDVController())->editHDV($_GET['id'], $_POST),
    // Xử lý phản hồi khách hàng
    'feedback'             => (new FeedbackController($db))->list(),
    'feedback-edit'        => (new FeedbackController($db))->edit(),
    'feedback-update'      => (new FeedbackController($db))->update(),
    // Xử lý đánh giá
    'suppliers'            => (new SupplierController($db))->index(),
    'supplier-add'         => (new SupplierController($db))->create(),
    'supplier-store'       => (new SupplierController($db))->store(),
    'supplier-edit'        => (new SupplierController($db))->edit(),
    'supplier-update'      => (new SupplierController($db))->update(),
    'supplier-delete'      => (new SupplierController($db))->destroy(),

    'supplier-contracts'       => (new SupplierController($db))->contracts(),
    'supplier-contract-store'  => (new SupplierController($db))->contractStore(),

    'supplier-quotes'          => (new SupplierController($db))->quotes(),
    'supplier-quote-store'     => (new SupplierController($db))->quoteStore(),

    'supplier-payments'        => (new SupplierController($db))->payments(),
    'supplier-payment-store'   => (new SupplierController($db))->paymentStore(),

    'supplier-debts'           => (new SupplierController($db))->debts(),
    'supplier-debt-store'      => (new SupplierController($db))->debtStore(),

    'supplier-compare-quotes'  => (new SupplierController($db))->compareQuotes(),
    'supplier-summary'         => (new SupplierController($db))->supplierSummary(),
};