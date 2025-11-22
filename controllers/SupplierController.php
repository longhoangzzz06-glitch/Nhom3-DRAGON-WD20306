<?php

class SupplierController {
    private $db;
    private $supplierModel;
    private $contractModel;
    private $quoteModel;
    private $paymentModel;
    private $debtModel;

    public function __construct($db){
        $this->db = $db;
        $this->supplierModel = new Supplier($db);
        $this->contractModel = new SupplierContract($db);
        $this->quoteModel = new SupplierQuote($db);
        $this->paymentModel = new SupplierPayment($db);
        $this->debtModel = new SupplierDebt($db);
    }

    // LIST suppliers
    public function index(){
        $q = $_GET['q'] ?? null;
        $stype = $_GET['stype'] ?? null;
        $page = max(1, (int)($_GET['page'] ?? 1));
        $limit = 20;
        $suppliers = $this->supplierModel->getAll($limit,($page-1)*$limit,['service_type'=>$stype,'q'=>$q]);
        require PATH_ROOT . 'views/supplier/list.php';
    }

    public function createSupplier(){
        require PATH_ROOT . 'views/supplier/create.php';
    }

    public function store(){
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?act=suppliers');
            exit;
        }

        $data = [
            'name'=>$_POST['name'] ?? null,
            'service_type'=>$_POST['service_type'] ?? 'other',
            'address'=>$_POST['address'] ?? null,
            'contact_name'=>$_POST['contact_name'] ?? null,
            'contact_phone'=>$_POST['contact_phone'] ?? null,
            'contact_email'=>$_POST['contact_email'] ?? null,
            'capacity'=>$_POST['capacity'] ?? null,
            'notes'=>$_POST['notes'] ?? null
        ];
        $this->supplierModel->create($data);
        header('Location: index.php?act=suppliers');
        exit;
    }

    public function edit(){
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?act=suppliers');
            exit;
        }
        $supplier = $this->supplierModel->getById($id);
        require PATH_ROOT . 'views/supplier/edit.php';
    }

    public function update(){
        $id = $_POST['id'] ?? null;
        if (!$id) {
            header('Location: index.php?act=suppliers');
            exit;
        }

        $data = [
            'name'=>$_POST['name'] ?? null,
            'service_type'=>$_POST['service_type'] ?? 'other',
            'address'=>$_POST['address'] ?? null,
            'contact_name'=>$_POST['contact_name'] ?? null,
            'contact_phone'=>$_POST['contact_phone'] ?? null,
            'contact_email'=>$_POST['contact_email'] ?? null,
            'capacity'=>$_POST['capacity'] ?? null,
            'notes'=>$_POST['notes'] ?? null
        ];
        $this->supplierModel->update($id,$data);
        header('Location: index.php?act=suppliers');
        exit;
    }

    public function destroy(){
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->supplierModel->delete($id);
        }
        header('Location: index.php?act=suppliers');
        exit;
    }

    // Contracts management
    public function contracts(){
        $supplier_id = $_GET['supplier_id'] ?? null;
        if (!$supplier_id) {
            header('Location: index.php?act=suppliers');
            exit;
        }
        $contracts = $this->contractModel->getBySupplier($supplier_id);
        $supplier = $this->supplierModel->getById($supplier_id);
        require PATH_ROOT . 'views/supplier/contract.php';
    }

    public function contractStore(){
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            header('Location: index.php?act=suppliers');
            exit;
        }

        $supplier_id = $_POST['supplier_id'] ?? null;
        if (empty($supplier_id)){
            header('Location: index.php?act=suppliers&error=missing_supplier');
            exit;
        }

        $title = trim($_POST['title'] ?? '');
        $start_date = $_POST['start_date'] ?? null;
        $end_date = $_POST['end_date'] ?? null;
        $terms = $_POST['terms'] ?? null;
        $total_value = isset($_POST['total_value']) && $_POST['total_value'] !== '' 
            ? (float) str_replace([',',' '], ['', ''], $_POST['total_value']) 
            : null;
        $status = $_POST['status'] ?? 'draft';

        $contract_file = null;
        if (!empty($_FILES['contract_file']['name'])) {
            $uploadDir = PATH_ROOT . 'uploads/contracts/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $safeName = time() . '_' . preg_replace('/[^A-Za-z0-9\._-]/', '_', basename($_FILES['contract_file']['name']));
            $dest = $uploadDir . $safeName;
            if (move_uploaded_file($_FILES['contract_file']['tmp_name'], $dest)) {
                $contract_file = $safeName;
            }
        }

        $data = [
            'supplier_id'  => $supplier_id,
            'title'        => $title,
            'start_date'   => $start_date,
            'end_date'     => $end_date,
            'terms'        => $terms,
            'contract_file'=> $contract_file,
            'total_value'  => $total_value,
            'status'       => $status
        ];

        try {
            $this->contractModel->create($data);
        } catch (PDOException $e) {
            header('Location: index.php?act=suppliers&error=db');
            exit;
        }

        header('Location: index.php?act=suppliers');
        exit;
    }

    // Quotes
    public function quotes(){
        $supplier_id = $_GET['supplier_id'] ?? null;
        if (!$supplier_id) {
            header('Location: index.php?act=suppliers');
            exit;
        }
        $quotes = $this->quoteModel->getBySupplier($supplier_id);
        $supplier = $this->supplierModel->getById($supplier_id);
        require PATH_ROOT . 'views/supplier/quotes.php';
    }

    public function quoteStore(){
        $supplier_id = $_POST['supplier_id'] ?? null;
        if (!$supplier_id) {
            header('Location: index.php?act=suppliers');
            exit;
        }

        $filePath = null;
        if(!empty($_FILES['quote_file']['name'])){
            $uploadDir = PATH_ROOT . 'uploads/quotes/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $fname = time().'_'.preg_replace('/[^A-Za-z0-9\._-]/', '_', basename($_FILES['quote_file']['name']));
            $dest = $uploadDir . $fname;
            if (move_uploaded_file($_FILES['quote_file']['tmp_name'], $dest)) {
                $filePath = $fname;
            }
        }

        $data = [
            'supplier_id'=>$supplier_id,
            'quote_title'=>$_POST['quote_title'] ?? null,
            'service_description'=>$_POST['service_description'] ?? null,
            'unit_price'=>$_POST['unit_price'] ?? null,
            'currency'=>$_POST['currency'] ?? 'VND',
            'valid_from'=>$_POST['valid_from'] ?? null,
            'valid_to'=>$_POST['valid_to'] ?? null,
            'quote_file'=>$filePath
        ];
        $this->quoteModel->create($data);
        header('Location: index.php?act=supplier-quotes&supplier_id='.$supplier_id);
        exit;
    }

    // Payments
    public function payments(){
        $supplier_id = $_GET['supplier_id'] ?? null;
        if (!$supplier_id) {
            header('Location: index.php?act=suppliers');
            exit;
        }
        $payments = $this->paymentModel->getBySupplier($supplier_id);
        $supplier = $this->supplierModel->getById($supplier_id);
        require PATH_ROOT . 'views/supplier/payments.php';
    }

    public function paymentStore(){
        $supplier_id = $_POST['supplier_id'] ?? null;
        if (!$supplier_id) {
            header('Location: index.php?act=suppliers');
            exit;
        }

        $data = [
            'supplier_id'=>$supplier_id,
            'contract_id'=>$_POST['contract_id'] ?? null,
            'amount'=>$_POST['amount'] ?? null,
            'currency'=>$_POST['currency'] ?? 'VND',
            'payment_date'=>$_POST['payment_date'] ?? date('Y-m-d H:i:s'),
            'method'=>$_POST['method'] ?? 'bank_transfer',
            'invoice_no'=>$_POST['invoice_no'] ?? null,
            'notes'=>$_POST['notes'] ?? null,
            'created_by'=>$_POST['created_by'] ?? null
        ];
        $this->paymentModel->create($data);
        header('Location: index.php?act=supplier-payments&supplier_id='.$supplier_id);
        exit;
    }

    // Debts
    public function debts(){
        $supplier_id = $_GET['supplier_id'] ?? null;
        if (!$supplier_id) {
            header('Location: index.php?act=suppliers');
            exit;
        }
        $debts = $this->debtModel->getOutstandingBySupplier($supplier_id);
        $supplier = $this->supplierModel->getById($supplier_id);
        require PATH_ROOT . 'views/supplier/debts.php';
    }

    public function debtStore(){
        $supplier_id = $_POST['supplier_id'] ?? null;
        if (!$supplier_id) {
            header('Location: index.php?act=suppliers');
            exit;
        }

        $data = [
            'supplier_id'=>$supplier_id,
            'related_contract_id'=>$_POST['related_contract_id'] ?? null,
            'amount'=>$_POST['amount'] ?? null,
            'due_date'=>$_POST['due_date'] ?? null,
            'status'=>$_POST['status'] ?? 'unpaid',
            'note'=>$_POST['note'] ?? null
        ];
        $this->debtModel->create($data);
        header('Location: index.php?act=supplier-debts&supplier_id='.$supplier_id);
        exit;
    }

    // Report: compare quotes by service keyword
    public function compareQuotes(){
        $service = $_GET['service'] ?? null;
        $results = $this->quoteModel->compareForService($service);
        require PATH_ROOT . 'views/supplier/compare_quotes.php';
    }

    // Report: supplier summary (total paid, total debts)
    public function supplierSummary(){
        $supplier_id = $_GET['supplier_id'] ?? null;
        if (!$supplier_id) {
            header('Location: index.php?act=suppliers');
            exit;
        }
        $payments = $this->paymentModel->getBySupplier($supplier_id);
        $debts = $this->debtModel->getOutstandingBySupplier($supplier_id);
        $supplier = $this->supplierModel->getById($supplier_id);
        require PATH_ROOT . 'views/supplier/summary.php';
    }
}
