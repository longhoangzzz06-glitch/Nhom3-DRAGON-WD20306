<?php

class SupplierController {
    private $db;
    private $supplierModel;
    private $contractModel;
    private $quoteModel;
    private $paymentModel;
    private $debtModel;

    public function __construct($db) {
        if (!($db instanceof PDO)) {
            throw new InvalidArgumentException("Constructor requires PDO instance");
        }
        $this->db = $db;
        $this->supplierModel = new Supplier($db);
        $this->contractModel = new SupplierContract($db);
        $this->quoteModel = new SupplierQuote($db);
        $this->paymentModel = new SupplierPayment($db);
        $this->debtModel = new SupplierDebt($db);
    }

    // LIST suppliers
    public function index() {
        try {
            $q = $_GET['q'] ?? null;
            $stype = $_GET['stype'] ?? null;
            $page = max(1, (int)($_GET['page'] ?? 1));
            $limit = 20;
            $offset = ($page - 1) * $limit;
            
            $suppliers = $this->supplierModel->getAll($limit, $offset, [
                'service_type' => $stype,
                'q' => $q
            ]);
            $total = count($suppliers);
            $totalPages = ceil($total / $limit);
            
            require PATH_ROOT . 'views/supplier/list.php';
        } catch (Exception $e) {
            header('HTTP/1.1 500 Internal Server Error');
            echo "Lỗi: " . htmlspecialchars($e->getMessage());
            exit;
        }
    }

    public function create() {
        try {
            require PATH_ROOT . 'views/supplier/create.php';
        } catch (Exception $e) {
            header('HTTP/1.1 500 Internal Server Error');
            echo "Lỗi: " . htmlspecialchars($e->getMessage());
            exit;
        }
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?act=suppliers');
            exit;
        }

        $name = $_POST['name'] ?? null;
        if (empty($name)) {
            header('Location: index.php?act=supplier-create&error=missing_name');
            exit;
        }

        try {
            $data = [
                'name' => trim($name),
                'service_type' => $_POST['service_type'] ?? 'other',
                'address' => $_POST['address'] ?? null,
                'contact_name' => $_POST['contact_name'] ?? null,
                'contact_phone' => $_POST['contact_phone'] ?? null,
                'contact_email' => $_POST['contact_email'] ?? null,
                'capacity' => $_POST['capacity'] ?? null,
                'notes' => $_POST['notes'] ?? null
            ];
            
            $this->supplierModel->create($data);
            header('Location: index.php?act=suppliers&success=created');
            exit;
        } catch (Exception $e) {
            header('Location: index.php?act=supplier-create&error=db');
            exit;
        }
    }

    public function edit() {
        try {
            $id = $_GET['id'] ?? null;
            if (!$id) {
                header('Location: index.php?act=suppliers');
                exit;
            }
            
            $supplier = $this->supplierModel->getById($id);
            if (!$supplier) {
                header('HTTP/1.1 404 Not Found');
                echo "Nhà cung cấp không tồn tại";
                exit;
            }
            
            require PATH_ROOT . 'views/supplier/edit.php';
        } catch (Exception $e) {
            header('HTTP/1.1 500 Internal Server Error');
            echo "Lỗi: " . htmlspecialchars($e->getMessage());
            exit;
        }
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?act=suppliers');
            exit;
        }

        $id = $_POST['id'] ?? null;
        if (!$id) {
            header('Location: index.php?act=suppliers');
            exit;
        }

        $name = $_POST['name'] ?? null;
        if (empty($name)) {
            header('Location: index.php?act=supplier-edit&id=' . $id . '&error=missing_name');
            exit;
        }

        try {
            $data = [
                'name' => trim($name),
                'service_type' => $_POST['service_type'] ?? 'other',
                'address' => $_POST['address'] ?? null,
                'contact_name' => $_POST['contact_name'] ?? null,
                'contact_phone' => $_POST['contact_phone'] ?? null,
                'contact_email' => $_POST['contact_email'] ?? null,
                'capacity' => $_POST['capacity'] ?? null,
                'notes' => $_POST['notes'] ?? null
            ];
            
            $this->supplierModel->update($id, $data);
            header('Location: index.php?act=suppliers&success=updated');
            exit;
        } catch (Exception $e) {
            header('Location: index.php?act=supplier-edit&id=' . $id . '&error=db');
            exit;
        }
    }

    public function delete() {
        try {
            $id = $_GET['id'] ?? null;
            if (!$id) {
                header('Location: index.php?act=suppliers');
                exit;
            }
            
            $this->supplierModel->delete($id);
            header('Location: index.php?act=suppliers&success=deleted');
            exit;
        } catch (Exception $e) {
            header('Location: index.php?act=suppliers&error=delete_failed');
            exit;
        }
    }

    // Contracts management
    public function contracts() {
        try {
            $supplier_id = $_GET['supplier_id'] ?? null;
            if (!$supplier_id) {
                header('Location: index.php?act=suppliers');
                exit;
            }
            
            $supplier = $this->supplierModel->getById($supplier_id);
            if (!$supplier) {
                header('HTTP/1.1 404 Not Found');
                echo "Nhà cung cấp không tồn tại";
                exit;
            }
            
            $contracts = $this->contractModel->getBySupplier($supplier_id);
            require PATH_ROOT . 'views/supplier/contracts.php';
        } catch (Exception $e) {
            header('HTTP/1.1 500 Internal Server Error');
            echo "Lỗi: " . htmlspecialchars($e->getMessage());
            exit;
        }
    }

    public function contractStore() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?act=suppliers');
            exit;
        }

        $supplier_id = $_POST['supplier_id'] ?? null;
        if (empty($supplier_id)) {
            header('Location: index.php?act=supplier-contracts&supplier_id=' . $supplier_id . '&error=missing_supplier');
            exit;
        }

        $title = trim($_POST['title'] ?? '');
        if (empty($title)) {
            header('Location: index.php?act=supplier-contracts&supplier_id=' . $supplier_id . '&error=missing_title');
            exit;
        }

        try {
            $start_date = $_POST['start_date'] ?? null;
            $end_date = $_POST['end_date'] ?? null;
            $terms = $_POST['terms'] ?? null;
            $total_value = isset($_POST['total_value']) && $_POST['total_value'] !== '' 
                ? (float) str_replace([',', ' '], ['', ''], $_POST['total_value']) 
                : null;
            $status = $_POST['status'] ?? 'draft';

            $contract_file = null;
            if (!empty($_FILES['contract_file']['name'])) {
                $uploadDir = PATH_ROOT . 'uploads/contracts/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                
                $maxSize = 10 * 1024 * 1024; // 10MB
                if ($_FILES['contract_file']['size'] > $maxSize) {
                    header('Location: index.php?act=supplier-contracts&supplier_id=' . $supplier_id . '&error=file_too_large');
                    exit;
                }

                $safeName = time() . '_' . preg_replace('/[^A-Za-z0-9\._-]/', '_', basename($_FILES['contract_file']['name']));
                $dest = $uploadDir . $safeName;
                
                if (move_uploaded_file($_FILES['contract_file']['tmp_name'], $dest)) {
                    $contract_file = $safeName;
                }
            }

            $data = [
                'supplier_id' => $supplier_id,
                'title' => $title,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'terms' => $terms,
                'contract_file' => $contract_file,
                'total_value' => $total_value,
                'status' => $status
            ];

            $this->contractModel->create($data);
            header('Location: index.php?act=supplier-contracts&supplier_id=' . $supplier_id . '&success=contract_created');
            exit;
        } catch (Exception $e) {
            header('Location: index.php?act=supplier-contracts&supplier_id=' . $supplier_id . '&error=db');
            exit;
        }
    }

    // Quotes
    public function quotes() {
        try {
            $supplier_id = $_GET['supplier_id'] ?? null;
            if (!$supplier_id) {
                header('Location: index.php?act=suppliers');
                exit;
            }
            
            $supplier = $this->supplierModel->getById($supplier_id);
            if (!$supplier) {
                header('HTTP/1.1 404 Not Found');
                echo "Nhà cung cấp không tồn tại";
                exit;
            }
            
            $quotes = $this->quoteModel->getBySupplier($supplier_id);
            require PATH_ROOT . 'views/supplier/quotes.php';
        } catch (Exception $e) {
            header('HTTP/1.1 500 Internal Server Error');
            echo "Lỗi: " . htmlspecialchars($e->getMessage());
            exit;
        }
    }

    public function quoteStore() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?act=suppliers');
            exit;
        }

        $supplier_id = $_POST['supplier_id'] ?? null;
        if (!$supplier_id) {
            header('Location: index.php?act=suppliers');
            exit;
        }

        try {
            $filePath = null;
            if (!empty($_FILES['quote_file']['name'])) {
                $uploadDir = PATH_ROOT . 'uploads/quotes/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                
                $maxSize = 5 * 1024 * 1024; // 5MB
                if ($_FILES['quote_file']['size'] > $maxSize) {
                    header('Location: index.php?act=supplier-quotes&supplier_id=' . $supplier_id . '&error=file_too_large');
                    exit;
                }

                $fname = time() . '_' . preg_replace('/[^A-Za-z0-9\._-]/', '_', basename($_FILES['quote_file']['name']));
                $dest = $uploadDir . $fname;
                
                if (move_uploaded_file($_FILES['quote_file']['tmp_name'], $dest)) {
                    $filePath = $fname;
                }
            }

            $unit_price = $_POST['unit_price'] ?? null;
            if (empty($unit_price)) {
                header('Location: index.php?act=supplier-quotes&supplier_id=' . $supplier_id . '&error=missing_price');
                exit;
            }

            $data = [
                'supplier_id' => $supplier_id,
                'quote_title' => $_POST['quote_title'] ?? null,
                'service_description' => $_POST['service_description'] ?? null,
                'unit_price' => (float) str_replace([',', ' '], ['', ''], $unit_price),
                'currency' => $_POST['currency'] ?? 'VND',
                'valid_from' => $_POST['valid_from'] ?? null,
                'valid_to' => $_POST['valid_to'] ?? null,
                'quote_file' => $filePath
            ];
            
            $this->quoteModel->create($data);
            header('Location: index.php?act=supplier-quotes&supplier_id=' . $supplier_id . '&success=quote_created');
            exit;
        } catch (Exception $e) {
            header('Location: index.php?act=supplier-quotes&supplier_id=' . $supplier_id . '&error=db');
            exit;
        }
    }

    // Payments
    public function payments() {
        try {
            $supplier_id = $_GET['supplier_id'] ?? null;
            if (!$supplier_id) {
                header('Location: index.php?act=suppliers');
                exit;
            }
            
            $supplier = $this->supplierModel->getById($supplier_id);
            if (!$supplier) {
                header('HTTP/1.1 404 Not Found');
                echo "Nhà cung cấp không tồn tại";
                exit;
            }
            
            $payments = $this->paymentModel->getBySupplier($supplier_id);
            require PATH_ROOT . 'views/supplier/payments.php';
        } catch (Exception $e) {
            header('HTTP/1.1 500 Internal Server Error');
            echo "Lỗi: " . htmlspecialchars($e->getMessage());
            exit;
        }
    }

    public function paymentStore() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?act=suppliers');
            exit;
        }

        $supplier_id = $_POST['supplier_id'] ?? null;
        if (!$supplier_id) {
            header('Location: index.php?act=suppliers');
            exit;
        }

        $amount = $_POST['amount'] ?? null;
        if (empty($amount)) {
            header('Location: index.php?act=supplier-payments&supplier_id=' . $supplier_id . '&error=missing_amount');
            exit;
        }

        try {
            $data = [
                'supplier_id' => $supplier_id,
                'contract_id' => $_POST['contract_id'] ?? null,
                'amount' => (float) str_replace([',', ' '], ['', ''], $amount),
                'currency' => $_POST['currency'] ?? 'VND',
                'payment_date' => $_POST['payment_date'] ?? date('Y-m-d H:i:s'),
                'method' => $_POST['method'] ?? 'bank_transfer',
                'invoice_no' => $_POST['invoice_no'] ?? null,
                'notes' => $_POST['notes'] ?? null,
                'created_by' => $_SESSION['user_id'] ?? null
            ];
            
            $this->paymentModel->create($data);
            header('Location: index.php?act=supplier-payments&supplier_id=' . $supplier_id . '&success=payment_created');
            exit;
        } catch (Exception $e) {
            header('Location: index.php?act=supplier-payments&supplier_id=' . $supplier_id . '&error=db');
            exit;
        }
    }

    // Debts
    public function debts() {
        try {
            $supplier_id = $_GET['supplier_id'] ?? null;
            if (!$supplier_id) {
                header('Location: index.php?act=suppliers');
                exit;
            }
            
            $supplier = $this->supplierModel->getById($supplier_id);
            if (!$supplier) {
                header('HTTP/1.1 404 Not Found');
                echo "Nhà cung cấp không tồn tại";
                exit;
            }
            
            $debts = $this->debtModel->getBySupplier($supplier_id);
            require PATH_ROOT . 'views/supplier/debts.php';
        } catch (Exception $e) {
            header('HTTP/1.1 500 Internal Server Error');
            echo "Lỗi: " . htmlspecialchars($e->getMessage());
            exit;
        }
    }

    public function debtStore() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?act=suppliers');
            exit;
        }

        $supplier_id = $_POST['supplier_id'] ?? null;
        if (!$supplier_id) {
            header('Location: index.php?act=suppliers');
            exit;
        }

        $amount = $_POST['amount'] ?? null;
        if (empty($amount)) {
            header('Location: index.php?act=supplier-debts&supplier_id=' . $supplier_id . '&error=missing_amount');
            exit;
        }

        try {
            $data = [
                'supplier_id' => $supplier_id,
                'contract_id' => $_POST['contract_id'] ?? null,
                'total_cost' => (float) str_replace([',', ' '], ['', ''], $amount),
                'paid_amount' => 0,
                'last_payment_date' => null,
                'note' => $_POST['note'] ?? null
            ];
            
            $this->debtModel->create($data);
            header('Location: index.php?act=supplier-debts&supplier_id=' . $supplier_id . '&success=debt_created');
            exit;
        } catch (Exception $e) {
            header('Location: index.php?act=supplier-debts&supplier_id=' . $supplier_id . '&error=db');
            exit;
        }
    }

    // Report: compare quotes by service keyword
    public function compareQuotes() {
        try {
            $service = $_GET['service'] ?? null;
            $results = [];
            
            if ($service) {
                $results = $this->quoteModel->compareForService($service);
            }
            
            require PATH_ROOT . 'views/supplier/compare_quotes.php';
        } catch (Exception $e) {
            header('HTTP/1.1 500 Internal Server Error');
            echo "Lỗi: " . htmlspecialchars($e->getMessage());
            exit;
        }
    }

    // Report: supplier summary (total paid, total debts)
    public function supplierSummary() {
        try {
            $supplier_id = $_GET['supplier_id'] ?? null;
            if (!$supplier_id) {
                header('Location: index.php?act=suppliers');
                exit;
            }
            
            $supplier = $this->supplierModel->getById($supplier_id);
            if (!$supplier) {
                header('HTTP/1.1 404 Not Found');
                echo "Nhà cung cấp không tồn tại";
                exit;
            }
            
            $payments = $this->paymentModel->getBySupplier($supplier_id);
            $debts = $this->debtModel->getBySupplier($supplier_id);
            
            require PATH_ROOT . 'views/supplier/summary.php';
        } catch (Exception $e) {
            header('HTTP/1.1 500 Internal Server Error');
            echo "Lỗi: " . htmlspecialchars($e->getMessage());
            exit;
        }
    }
}
