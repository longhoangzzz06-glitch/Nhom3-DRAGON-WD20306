<?php

class FeedbackController {
    private $model;

    public function __construct($db) {
        $this->model = new Feedback($db);
    }

    public function index() {
        $feedbacks = $this->model->getAll();
        require PATH_ROOT . 'views/feedback/index.php';
    }

    public function create() {
        require PATH_ROOT . 'views/feedback/add.php';
    }

    public function store() {
        $image = $this->handleImageUpload($_FILES['image'] ?? null);

        $data = [
            'tour_id' => $_POST['tour_id'] ?? null,
            'supplier_id' => $_POST['supplier_id'] ?? null,
            'customer_name' => $_POST['customer_name'],
            'customer_phone' => $_POST['customer_phone'],
            'rating_tour' => $_POST['rating_tour'],
            'rating_service' => $_POST['rating_service'],
            'rating_staff' => $_POST['rating_staff'],
            'comment' => $_POST['comment'] ?? null,
            'image' => $image
        ];

        $this->model->create($data);
        header("Location: index.php?act=feedback");
        exit;
    }

    public function edit() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: index.php?act=feedback");
            exit;
        }
        $feedback = $this->model->getById($id);
        require PATH_ROOT . 'views/feedback/edit.php';
    }

    public function update() {
        $id = $_POST['id'] ?? null;
        if (!$id) {
            header("Location: index.php?act=feedback");
            exit;
        }

        $image = $_POST['image_old'] ?? null;
        if (!empty($_FILES['image']['name'])) {
            $image = $this->handleImageUpload($_FILES['image']);
        }

        $data = [
            'tour_id' => $_POST['tour_id'] ?? null,
            'supplier_id' => $_POST['supplier_id'] ?? null,
            'customer_name' => $_POST['customer_name'],
            'customer_phone' => $_POST['customer_phone'],
            'rating_tour' => $_POST['rating_tour'],
            'rating_service' => $_POST['rating_service'],
            'rating_staff' => $_POST['rating_staff'],
            'comment' => $_POST['comment'] ?? null,
            'image' => $image
        ];

        $this->model->update($id, $data);
        header("Location: index.php?act=feedback");
        exit;
    }

    public function delete() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->model->delete($id);
        }
        header("Location: index.php?act=feedback");
        exit;
    }

    private function handleImageUpload($file) {
        if (empty($file) || empty($file['name'])) {
            return "";
        }
        $filename = time() . "_" . basename($file['name']);
        $uploadDir = PATH_ROOT . 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        move_uploaded_file($file['tmp_name'], $uploadDir . $filename);
        return $filename;
    }
}