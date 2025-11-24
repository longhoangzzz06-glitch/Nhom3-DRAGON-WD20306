<?php
class TourPackageController {
    private $db;
    private $packageModel;

    public function __construct($db) {
        $this->db = $db;
        $this->packageModel = new TourPackage($db);
    }

    public function index() {
        $tour_id = $_GET['tour_id'];
        $packages = $this->packageModel->allByTour($tour_id);
        require_once './views/packages/index.php';
    }

    public function create() {
        $tour_id = $_GET['tour_id'];
        require_once './views/packages/create.php';
    }

    public function store() {
        $data = [
            'tour_id' => $_POST['tour_id'],
            'package_name' => $_POST['package_name'],
            'price' => $_POST['price'],
            'description' => $_POST['description']
        ];

        $this->packageModel->create($data);
        header("Location: index.php?act=tour-packages&tour_id=" . $_POST['tour_id']);
    }

    public function edit() {
        $id = $_GET['id'];
        $package = $this->packageModel->find($id);
        require_once './views/packages/edit.php';
    }

    public function update() {
        $id = $_POST['id'];
        $data = [
            'package_name' => $_POST['package_name'],
            'price' => $_POST['price'],
            'description' => $_POST['description']
        ];

        $this->packageModel->update($id, $data);
        header("Location: index.php?act=tour-packages&tour_id=" . $_POST['tour_id']);
    }

    public function delete() {
        $id = $_GET['id'];
        $tour_id = $_GET['tour_id'];
        $this->packageModel->delete($id);
        header("Location: index.php?act=tour-packages&tour_id=$tour_id");
    }
}
