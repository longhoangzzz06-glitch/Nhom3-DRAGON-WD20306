<?php
class TourController {
    private $db;
    private $tourModel;

    public function __construct($db) {
        $this->db = $db;
        $this->tourModel = new Tour($db);
    }

    public function index() {
        $tours = $this->tourModel->all();
        require_once './views/tours/index.php';
    }

    public function create() {
        require_once './views/tours/create.php';
    }

    public function store() {
        $data = [
            'tour_name' => $_POST['tour_name'],
            'start_date' => $_POST['start_date'],
            'end_date' => $_POST['end_date'],
            'base_price' => $_POST['base_price'],
            'description' => $_POST['description']
        ];

        $this->tourModel->create($data);
        header('Location: index.php?act=tours');
    }

    public function edit() {
        $id = $_GET['id'];
        $tour = $this->tourModel->find($id);
        require_once './views/tours/edit.php';
    }

    public function update() {
        $id = $_POST['id'];
        $data = [
            'tour_name' => $_POST['tour_name'],
            'start_date' => $_POST['start_date'],
            'end_date' => $_POST['end_date'],
            'base_price' => $_POST['base_price'],
            'description' => $_POST['description']
        ];

        $this->tourModel->update($id, $data);
        header('Location: index.php?act=tours');
    }

    public function delete() {
        $id = $_GET['id'];
        $this->tourModel->delete($id);
        header('Location: index.php?act=tours');
    }
}
