<?php

class SupplierController
{
    private $model;

    public function __construct()
    {
        $this->model = new Supplier();
    }

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

        require "./views/supplier/index.php";
    }

    public function create()
    {
        require "./views/supplier/create.php";
    }

    public function store()
    {
        $logo = null;

        if (!empty($_FILES['logo']['name'])) {
            $logo = "uploads/suppliers/" . time() . "_" . $_FILES['logo']['name'];
            move_uploaded_file($_FILES['logo']['tmp_name'], $logo);
        }

        $data = [
            'ten' => $_POST['ten'] ?? '',
            'loai_dich_vu' => $_POST['loai_dich_vu'] ?? '',
            'dien_thoai' => $_POST['dien_thoai'] ?? '',
            'email' => $_POST['email'] ?? '',
            'dia_chi' => $_POST['dia_chi'] ?? '',
            'ghi_chu' => $_POST['ghi_chu'] ?? '',
            'logo' => $logo
        ];

        $this->model->insert($data);

        header("Location: index.php?act=quan-ly-supplier");
        exit;
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: index.php?act=quan-ly-supplier");
            exit;
        }

        $supplier = $this->model->find($id);
        require "./views/supplier/edit.php";
    }

    public function update()
    {
        $id = $_POST['id'] ?? null;

        if (!$id) {
            header("Location: index.php?act=quan-ly-supplier");
            exit;
        }

        $supplier = $this->model->find($id);

        $logo = $supplier['logo'] ?? null;

        if (!empty($_FILES['logo']['name'])) {
            $logo = "uploads/suppliers/" . time() . "_" . $_FILES['logo']['name'];
            move_uploaded_file($_FILES['logo']['tmp_name'], $logo);
        }

        $data = [
            'ten' => $_POST['ten'] ?? '',
            'loai_dich_vu' => $_POST['loai_dich_vu'] ?? '',
            'dien_thoai' => $_POST['dien_thoai'] ?? '',
            'email' => $_POST['email'] ?? '',
            'dia_chi' => $_POST['dia_chi'] ?? '',
            'ghi_chu' => $_POST['ghi_chu'] ?? '',
            'logo' => $logo,
            'id' => $id
        ];

        $this->model->update($id, $data);

        header("Location: index.php?act=quan-ly-supplier");
        exit;
    }

    public function delete()
    {
        $id = $_GET['id'] ?? null;

        if ($id) {
            $this->model->delete($id);
        }

        header("Location: index.php?act=quan-ly-supplier");
        exit;
    }
}
