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
        include './views/suppliers/suppliers_list.php';
    }

    public function create(){
        require PATH_ROOT . 'views/suppliers/add.php';
    }

    public function store(){
        // validate minimal
        $data = [
            'name'=>$_POST['name'],
            'service_type'=>$_POST['service_type'] ?? 'other',
            'address'=>$_POST['address'] ?? null,
            'contact_name'=>$_POST['contact_name'] ?? null,
            'contact_phone'=>$_POST['contact_phone'] ?? null,
            'contact_email'=>$_POST['contact_email'] ?? null,
            'capacity'=>$_POST['capacity'] ?? null,
            'notes'=>$_POST['notes'] ?? null
        ];
        $this->supplierModel->create($data);
        header('Location: index.php?act=/suppliers');
        exit;
    }

    public function edit(){
        $id = $_GET['id'] ?? null;
        $supplier = $this->supplierModel->getById($id);
        require './views/suppliers/edit.php';
    }

    public function update(){
        $id = $_POST['id'];
        $data = [
            'name'=>$_POST['name'],
            'service_type'=>$_POST['service_type'] ?? 'other',
            'address'=>$_POST['address'] ?? null,
            'contact_name'=>$_POST['contact_name'] ?? null,
            'contact_phone'=>$_POST['contact_phone'] ?? null,
            'contact_email'=>$_POST['contact_email'] ?? null,
            'capacity'=>$_POST['capacity'] ?? null,
            'notes'=>$_POST['notes'] ?? null
        ];
        $this->supplierModel->update($id,$data);
        header('Location: index.php?act=/suppliers');
        exit;
    }

    public function destroy(){
        $id = $_GET['id'] ?? null;
        $this->supplierModel->delete($id);
        header('Location: index.php?act=/suppliers');
        exit;
    }

    // Contracts management
    public function contracts(){
        $supplier_id = $_GET['supplier_id'] ?? null;
        $contracts = $this->contractModel->getBySupplier($supplier_id);
        $supplier = $this->supplierModel->getById($supplier_id);
        require './views/suppliers/contracts.php';
    }

    public function contractStore(){
        // handle file upload
        $filePath = null;
        if(!empty($_FILES['contract_file']['name'])){
            $fname = time().'_'.basename($_FILES['contract_file']['name']);
            move_uploaded_file($_FILES['contract_file']['tmp_name'],'./uploads/contracts/'.$fname);
            $filePath = 'uploads/contracts/'.$fname;
        }
        $data = [
            'supplier_id'=>$_POST['supplier_id'],
            'title'=>$_POST['title'],
            'start_date'=>$_POST['start_date']?:null,
            'end_date'=>$_POST['end_date']?:null,
            'terms'=>$_POST['terms']?:null,
            'contract_file'=>$filePath,
            'total_value'=>$_POST['total_value']?:0,
            'status'=>$_POST['status']?:'draft'
        ];
        $this->contractModel->create($data);
        header('Location: index.php?act=/supplier-contracts&supplier_id='.$_POST['supplier_id']);
        exit;
    }

    // Quotes
    public function quotes(){
        $supplier_id = $_GET['supplier_id'] ?? null;
        $quotes = $this->quoteModel->getBySupplier($supplier_id);
        $supplier = $this->supplierModel->getById($supplier_id);
        require './views/suppliers/quotes.php';
    }

    public function quoteStore(){
        $filePath = null;
        if(!empty($_FILES['quote_file']['name'])){
            $fname = time().'_'.basename($_FILES['quote_file']['name']);
            move_uploaded_file($_FILES['quote_file']['tmp_name'],'./uploads/quotes/'.$fname);
            $filePath = 'uploads/quotes/'.$fname;
        }
        $data = [
            'supplier_id'=>$_POST['supplier_id'],
            'quote_title'=>$_POST['quote_title'],
            'service_description'=>$_POST['service_description'],
            'unit_price'=>$_POST['unit_price'],
            'currency'=>$_POST['currency']?:'VND',
            'valid_from'=>$_POST['valid_from']?:null,
            'valid_to'=>$_POST['valid_to']?:null,
            'quote_file'=>$filePath
        ];
        $this->quoteModel->create($data);
        header('Location: index.php?act=/supplier-quotes&supplier_id='.$_POST['supplier_id']);
        exit;
    }

    // Payments
    public function payments(){
        $supplier_id = $_GET['supplier_id'] ?? null;
        $payments = $this->paymentModel->getBySupplier($supplier_id);
        $supplier = $this->supplierModel->getById($supplier_id);
        require './views/suppliers/payments.php';
    }

    public function paymentStore(){
        $data = [
            'supplier_id'=>$_POST['supplier_id'],
            'contract_id'=>$_POST['contract_id']?:null,
            'amount'=>$_POST['amount'],
            'currency'=>$_POST['currency']?:'VND',
            'payment_date'=>$_POST['payment_date']?:date('Y-m-d H:i:s'),
            'method'=>$_POST['method']?:'bank_transfer',
            'invoice_no'=>$_POST['invoice_no']?:null,
            'notes'=>$_POST['notes']?:null,
            'created_by'=>$_POST['created_by']?:null
        ];
        $this->paymentModel->create($data);
        header('Location: index.php?act=/supplier-payments&supplier_id='.$_POST['supplier_id']);
        exit;
    }

    // Debts
    public function debts(){
        $supplier_id = $_GET['supplier_id'] ?? null;
        $debts = $this->debtModel->getOutstandingBySupplier($supplier_id);
        $supplier = $this->supplierModel->getById($supplier_id);
        require './views/suppliers/debts.php';
    }

    public function debtStore(){
        $data = [
            'supplier_id'=>$_POST['supplier_id'],
            'related_contract_id'=>$_POST['related_contract_id']?:null,
            'amount'=>$_POST['amount'],
            'due_date'=>$_POST['due_date']?:null,
            'status'=>$_POST['status']?:'unpaid',
            'note'=>$_POST['note']?:null
        ];
        $this->debtModel->create($data);
        header('Location: index.php?act=/supplier-debts&supplier_id='.$_POST['supplier_id']);
        exit;
    }

    // Report: compare quotes by service keyword
    public function compareQuotes(){
        $service = $_GET['service'] ?? null;
        $results = $this->quoteModel->compareForService($service);
        require './views/suppliers/compare_quotes.php';
    }

    // Report: supplier summary (total paid, total debts)
    public function supplierSummary(){
        $supplier_id = $_GET['supplier_id'] ?? null;
        $payments = $this->paymentModel->getBySupplier($supplier_id);
        $debts = $this->debtModel->getOutstandingBySupplier($supplier_id);
        $supplier = $this->supplierModel->getById($supplier_id);
        require './views/suppliers/summary.php';
    }
}
