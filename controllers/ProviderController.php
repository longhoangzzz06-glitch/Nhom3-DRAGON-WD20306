<?php
class ProviderController {

    private $providerModel;

    public function __construct($db) {
        $this->providerModel = new Provider($db);
    }

    public function index() {
        $providers = $this->providerModel->getAll();
        require PATH_ROOT . 'views/provider/index.php';
    }

    public function create() {
        require PATH_ROOT . 'views/provider/create.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?controller=provider&action=index");
            exit;
        }

        $data = [
            'name' => $_POST['name'] ?? null,
            'type' => $_POST['type'] ?? null,
            'address' => $_POST['address'] ?? null,
            'contact_person' => $_POST['contact_person'] ?? null,
            'phone' => $_POST['phone'] ?? null,
            'email' => $_POST['email'] ?? null,
            'description' => $_POST['description'] ?? null,
            'capacity' => $_POST['capacity'] ?? null
        ];

        $this->providerModel->create($data);
        header("Location: index.php?controller=provider&action=index");
        exit;
    }

    public function edit() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: index.php?controller=provider&action=index");
            exit;
        }
        $provider = $this->providerModel->find($id);
        require PATH_ROOT . 'views/provider/edit.php';
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?controller=provider&action=index");
            exit;
        }

        $id = $_POST['id'] ?? null;
        if (!$id) {
            header("Location: index.php?controller=provider&action=index");
            exit;
        }

        $data = [
            'name' => $_POST['name'] ?? null,
            'type' => $_POST['type'] ?? null,
            'address' => $_POST['address'] ?? null,
            'contact_person' => $_POST['contact_person'] ?? null,
            'phone' => $_POST['phone'] ?? null,
            'email' => $_POST['email'] ?? null,
            'description' => $_POST['description'] ?? null,
            'capacity' => $_POST['capacity'] ?? null
        ];

        $this->providerModel->update($id, $data);
        header("Location: index.php?controller=provider&action=index");
        exit;
    }

    public function delete() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: index.php?controller=provider&action=index");
            exit;
        }

        $this->providerModel->delete($id);
        header("Location: index.php?controller=provider&action=index");
        exit;
    }
}