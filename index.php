<?php 
// Require toàn bộ các file khai báo môi trường, thực thi,...(không require view)

// Require file Common
require_once './commons/env.php'; // Khai báo biến môi trường
require_once './commons/function.php'; // Hàm hỗ trợ

// Initialize database connection
$db = connectDB();

if (!$db) {
    header('HTTP/1.1 500 Internal Server Error');
    echo "Lỗi kết nối cơ sở dữ liệu";
    exit;
}

// Require toàn bộ file Models
require_once './models/HDVModel.php';
require_once './models/Feedback.php';
require_once './models/supplier/Supplier.php';
require_once './models/supplier/SupplierContract.php';
require_once './models/supplier/SupplierQuote.php';
require_once './models/supplier/SupplierPayment.php';
require_once './models/supplier/SupplierDebt.php';
require_once './models/PaymentReminder.php';
require_once './models/DebtModel.php';
require_once './models/FinanceModel.php';
require_once './models/tour/Tour.php';
require_once './models/tour/TourPackage.php';
require_once './models/tour/Booking.php';
require_once './models/tour/BookingStatus.php';
require_once './models/tour/BookingCustomer.php';
require_once './models/tour/SpecialNote.php';


// Require toàn bộ file Controllers
require_once './controllers/HDVController.php'; 
require_once './controllers/FeedbackController.php';
require_once './controllers/SupplierController.php';
require_once './controllers/ContractController.php';
require_once './controllers/ProviderController.php';
require_once './controllers/PaymentReminderController.php';
require_once './controllers/DebtController.php';
require_once './controllers/FinanceController.php';
require_once './controllers/TourController.php';
require_once './controllers/TourPackageController.php';
require_once './controllers/BookingController.php';
require_once './controllers/BookingStatusController.php';
require_once './controllers/BookingCustomerController.php';
require_once './controllers/SpecialNotesController.php';


// Route
$act = $_GET['act'] ?? 'home';

try {
    match ($act) {
        // HOME
        'home', '/' => (new HDVController($db))->index(),

        // TOUR GUIDES (Hướng dẫn viên)
        'tour-guides' => (new HDVController($db))->index(),
        'tour-guide-create' => (new HDVController($db))->create(),
        'tour-guide-store' => (new HDVController($db))->store(),
        'tour-guide-edit' => (new HDVController($db))->edit(),
        'tour-guide-update' => (new HDVController($db))->update(),
        'tour-guide-delete' => (new HDVController($db))->delete(),

        // FEEDBACK (Phản hồi khách hàng)
        'feedback' => (new FeedbackController($db))->index(),
        'feedback-create' => (new FeedbackController($db))->create(),
        'feedback-store' => (new FeedbackController($db))->store(),
        'feedback-edit' => (new FeedbackController($db))->edit(),
        'feedback-update' => (new FeedbackController($db))->update(),
        'feedback-delete' => (new FeedbackController($db))->delete(),

        // SUPPLIERS (Nhà cung cấp)
        'suppliers' => (new SupplierController($db))->index(),
        'supplier-create' => (new SupplierController($db))->create(),
        'supplier-store' => (new SupplierController($db))->store(),
        'supplier-edit' => (new SupplierController($db))->edit(),
        'supplier-update' => (new SupplierController($db))->update(),
        'supplier-delete' => (new SupplierController($db))->destroy(),

        // SUPPLIER CONTRACTS (Hợp đồng nhà cung cấp)
        'supplier-contracts' => (new SupplierController($db))->contracts(),
        'supplier-contract-store' => (new SupplierController($db))->contractStore(),

        // SUPPLIER QUOTES (Báo giá)
        'supplier-quotes' => (new SupplierController($db))->quotes(),
        'supplier-quote-store' => (new SupplierController($db))->quoteStore(),

        // SUPPLIER PAYMENTS (Thanh toán)
        'supplier-payments' => (new SupplierController($db))->payments(),
        'supplier-payment-store' => (new SupplierController($db))->paymentStore(),

        // SUPPLIER DEBTS (Công nợ)
        'supplier-debts' => (new SupplierController($db))->debts(),
        'supplier-debt-store' => (new SupplierController($db))->debtStore(),

        // SUPPLIER REPORTS (Báo cáo)
        'supplier-compare-quotes' => (new SupplierController($db))->compareQuotes(),
        'supplier-summary' => (new SupplierController($db))->supplierSummary(),

        // CONTRACTS (Hợp đồng)
        'contracts' => (new ContractController($db))->index(),
        'contract-create' => (new ContractController($db))->create(),
        'contract-store' => (new ContractController($db))->store(),
        'contract-edit' => (new ContractController($db))->edit(),
        'contract-update' => (new ContractController($db))->update(),
        'contract-delete' => (new ContractController($db))->delete(),
        'contract-expiring' => (new ContractController($db))->expiring(),

        // PROVIDERS (Nhà cung cấp dịch vụ)
        'providers' => (new ProviderController($db))->index(),
        'provider-create' => (new ProviderController($db))->create(),
        'provider-store' => (new ProviderController($db))->store(),
        'provider-edit' => (new ProviderController($db))->edit(),
        'provider-update' => (new ProviderController($db))->update(),
        'provider-delete' => (new ProviderController($db))->delete(),

        // PAYMENT REMINDERS (Nhắc thanh toán)
        'payment-reminders' => (new PaymentReminderController($db))->index(),
        'payment-reminder-create' => (new PaymentReminderController($db))->create(),
        'payment-reminder-store' => (new PaymentReminderController($db))->store(),
        'payment-reminder-auto-check' => (new PaymentReminderController($db))->autoCheck(),

        // DEBTS (Công nợ)
        'debts' => (new DebtController($db))->index(),
        'debt-create' => (new DebtController($db))->create(),
        'debt-store' => (new DebtController($db))->store(),
        'debt-detail' => (new DebtController($db))->detail(),
        'debt-payment-save' => (new DebtController($db))->savePayment(),
        'debt-delete' => (new DebtController($db))->delete(),
        'debt-outstanding' => (new DebtController($db))->outstanding(),
        'debt-upcoming' => (new DebtController($db))->upcoming(),

        // FINANCE (Tài chính)
        'finance' => (new FinanceController($db))->index(),
        'finance-create' => (new FinanceController($db))->create(),
        'finance-store' => (new FinanceController($db))->store(),
        'finance-edit' => (new FinanceController($db))->edit(),
        'finance-update' => (new FinanceController($db))->update(),
        'finance-delete' => (new FinanceController($db))->delete(),
        'finance-report' => (new FinanceController($db))->report(),
        'finance-comprehensive-report' => (new FinanceController($db))->comprehensiveReport(),
        'finance-cron-daily' => (new FinanceController($db))->cronDailySummary(),
        // =========================
// MODULE 7 – TOUR MANAGEMENT
// =========================

// TOURS
'tours'                 => (new TourController($db))->index(),
'tour-create'           => (new TourController($db))->create(),
'tour-store'            => (new TourController($db))->store(),
'tour-edit'             => (new TourController($db))->edit(),
'tour-update'           => (new TourController($db))->update(),
'tour-delete'           => (new TourController($db))->delete(),

// TOUR PACKAGES
'tour-packages'         => (new TourPackageController($db))->index(),
'tour-package-create'   => (new TourPackageController($db))->create(),
'tour-package-store'    => (new TourPackageController($db))->store(),
'tour-package-edit'     => (new TourPackageController($db))->edit(),
'tour-package-update'   => (new TourPackageController($db))->update(),
'tour-package-delete'   => (new TourPackageController($db))->delete(),

// BOOKINGS
'bookings'              => (new BookingController($db))->index(),
'booking-create'        => (new BookingController($db))->create(),
'booking-store'         => (new BookingController($db))->store(),
'booking-edit'          => (new BookingController($db))->edit(),
'booking-update'        => (new BookingController($db))->update(),
'booking-delete'        => (new BookingController($db))->delete(),

// BOOKING STATUS
'booking-status'        => (new BookingStatusController($db))->index(),
'booking-status-store'  => (new BookingStatusController($db))->store(),
'booking-status-history'=> (new BookingStatusController($db))->history(),

// BOOKING CUSTOMERS
'booking-customers'          => (new BookingCustomerController($db))->index(),
'booking-customer-add'       => (new BookingCustomerController($db))->add(),
'booking-customer-store'     => (new BookingCustomerController($db))->store(),
'booking-customer-delete'    => (new BookingCustomerController($db))->delete(),

// SPECIAL NOTES
'special-notes'          => (new SpecialNotesController($db))->index(),
'special-note-store'     => (new SpecialNotesController($db))->store(),
'special-note-delete'    => (new SpecialNotesController($db))->delete(),


        default => throw new Exception("Trang không tồn tại: " . htmlspecialchars($act))
    };
} catch (Exception $e) {
    header('HTTP/1.1 500 Internal Server Error');
    echo "<h2>Lỗi hệ thống</h2>";
    echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
    exit;
}
?>