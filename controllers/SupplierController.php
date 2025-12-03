<?php

class SupplierController
{
    private $model;

    public function __construct()
    {
        $this->model = new Supplier();
    }

    // Danh sách có tìm kiếm + phân trang
    public function index()
    {
        $keyword = $_GET['keyword'] ?? "";
        $service = $_GET['service'] ?? "";
        $page = $_GET['page'] ?? 1;
        $limit = 5;
        $offset = ($page - 1) * $limit;

        $suppliers = $this->model->getAll($keyword, $service, $limit, $offset);
        $total = $this->model->count($keyword, $service);
        $totalPages = ceil($total / $limit);

        require_once "./views/supplier/index.php";
    }

    public function create()
    {
        require_once "./views/supplier/create.php";
    }

    public function store()
    {
        $logo = null;

        if (!empty($_FILES['logo']['name'])) {
            $logo = "uploads/suppliers/" . time() . "_" . $_FILES['logo']['name'];
            move_uploaded_file($_FILES['logo']['tmp_name'], $logo);
        }

        $data = [
            'name' => $_POST['name'],
            'service_type' => $_POST['service_type'],
            'phone' => $_POST['phone'],
            'email' => $_POST['email'],
            'address' => $_POST['address'],
            'note' => $_POST['note'],
            'logo' => $logo
        ];

        $this->model->insert($data);

        header("Location: index.php?act=supplier");
        exit;
    }

    public function edit()
    {
        $supplier = $this->model->find($_GET['id']);
        require_once "./views/supplier/edit.php";
    }

    public function update()
    {
        $id = $_POST['id'];

        $supplier = $this->model->find($id);

        $logo = $supplier['logo']; // giữ logo cũ

        if (!empty($_FILES['logo']['name'])) {
            $logo = "uploads/suppliers/" . time() . "_" . $_FILES['logo']['name'];
            move_uploaded_file($_FILES['logo']['tmp_name'], $logo);
        }

        $data = [
            'name' => $_POST['name'],
            'service_type' => $_POST['service_type'],
            'phone' => $_POST['phone'],
            'email' => $_POST['email'],
            'address' => $_POST['address'],
            'note' => $_POST['note'],
            'logo' => $logo
        ];

        $this->model->update($id, $data);

        header("Location: index.php?act=supplier");
        exit;
    }

    public function delete()
    {
        $this->model->delete($_GET['id']);
        header("Location: index.php?act=supplier");
        exit;
    }
}
