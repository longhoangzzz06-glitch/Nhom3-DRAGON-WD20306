<?php
class ContractController
{
    private $contract;

    public function __construct($db)
    {
        $this->contract = new Contract($db);
    }

    public function index()
    {
        $contracts = $this->contract->all();
        require PATH_ROOT . 'views/contracts/index.php';
    }

    public function create()
    {
        require PATH_ROOT . 'views/contracts/create.php';
    }

    public function store()
    {
        $file_path = $this->handleFileUpload($_FILES['file'] ?? null);

        $this->contract->store([
            "supplier_id" => $_POST['supplier_id'] ?? null,
            "contract_number" => $_POST['contract_number'] ?? null,
            "start_date" => $_POST['start_date'] ?? null,
            "end_date" => $_POST['end_date'] ?? null,
            "payment_due" => $_POST['payment_due'] ?? null,
            "file_path" => $file_path
        ]);

        header("Location: index.php?controller=contract&action=index");
        exit;
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: index.php?controller=contract&action=index");
            exit;
        }
        $contract = $this->contract->find($id);
        require PATH_ROOT . 'views/contracts/edit.php';
    }

    public function update()
    {
        $id = $_POST['id'] ?? null;
        if (!$id) {
            header("Location: index.php?controller=contract&action=index");
            exit;
        }

        $contract = $this->contract->find($id);
        $file_path = $contract['file_path'] ?? null;

        if (!empty($_FILES['file']['name'])) {
            $file_path = $this->handleFileUpload($_FILES['file']);
        }

        $this->contract->update($id, [
            "supplier_id" => $_POST['supplier_id'] ?? null,
            "contract_number" => $_POST['contract_number'] ?? null,
            "start_date" => $_POST['start_date'] ?? null,
            "end_date" => $_POST['end_date'] ?? null,
            "payment_due" => $_POST['payment_due'] ?? null,
            "file_path" => $file_path
        ]);

        header("Location: index.php?controller=contract&action=index");
        exit;
    }

    public function delete()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->contract->delete($id);
        }
        header("Location: index.php?controller=contract&action=index");
        exit;
    }

    public function expiring()
    {
        $contracts = $this->contract->getExpiringContracts(30);
        require PATH_ROOT . 'views/contracts/expiring.php';
    }

    private function handleFileUpload($file)
    {
        if (empty($file) || empty($file['name'])) {
            return null;
        }

        $uploadDir = PATH_ROOT . 'uploads/contracts/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $filename = time() . "_" . basename($file['name']);
        move_uploaded_file($file['tmp_name'], $uploadDir . $filename);
        return $filename;
    }
}
