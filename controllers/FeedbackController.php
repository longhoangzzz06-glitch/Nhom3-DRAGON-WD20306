<?php
require_once 'models/Feedback.php';

class FeedbackController {
    private $model;

    public function __construct($db) {
        $this->model = new Feedback($db);
    }

    public function list() {
        $feedbacks = $this->model->getAll();
        include 'views/feedback/list.php';
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'tour_id' => $_POST['tour_id'],
                'customer_id' => $_POST['customer_id'],
                'supplier_id' => $_POST['supplier_id'] ?? null,
                'rating' => $_POST['rating'],
                'comment' => $_POST['comment']
            ];
            $this->model->add($data);
            header("Location: index.php?controller=feedback&action=list");
        }
        include 'views/feedback/add.php';
    }

    public function edit($id) {
        $feedback = $this->model->getById($id);
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'tour_id' => $_POST['tour_id'],
                'customer_id' => $_POST['customer_id'],
                'supplier_id' => $_POST['supplier_id'] ?? null,
                'rating' => $_POST['rating'],
                'comment' => $_POST['comment']
            ];
            $this->model->update($id, $data);
            header("Location: index.php?controller=feedback&action=list");
        }
        include 'views/feedback/edit.php';
    }
    public function update() {
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $data = [
                'tour_id' => $_POST['tour_id'],
                'customer_id' => $_POST['customer_id'],
                'supplier_id' => $_POST['supplier_id'] ?? null,
                'rating' => $_POST['rating'],
                'comment' => $_POST['comment']
            ];

            if ($this->model->update($id, $data)) {
                header("Location: index.php?controller=Feedback&action=index&msg=success");
                exit;
            } else {
                echo "Update failed!";
            }
        }
    }


    public function delete($id) {
        $this->model->delete($id);
        header("Location: index.php?controller=feedback&action=list");
    }
}
