<?php
class BookingController {
    private $db;
    private $bookingModel;

    public function __construct($db) {
        $this->db = $db;
        $this->bookingModel = new Booking($db);
    }

    public function index() {
        $bookings = $this->bookingModel->all();
        require_once './views/booking/index.php';
    }

    public function create() {
        require_once './views/booking/create.php';
    }

    public function store() {
        $data = [
            'tour_id' => $_POST['tour_id'],
            'package_id' => $_POST['package_id'],
            'customer_name' => $_POST['customer_name'],
            'phone' => $_POST['phone'],
            'email' => $_POST['email'],
            'total_price' => $_POST['total_price']
        ];

        $this->bookingModel->create($data);
        header("Location: index.php?act=bookings");
    }

    public function edit() {
        $id = $_GET['id'];
        $booking = $this->bookingModel->find($id);
        require_once './views/booking/edit.php';
    }

    public function update() {
        $id = $_POST['id'];

        $data = [
            'tour_id' => $_POST['tour_id'],
            'package_id' => $_POST['package_id'],
            'customer_name' => $_POST['customer_name'],
            'phone' => $_POST['phone'],
            'email' => $_POST['email'],
            'total_price' => $_POST['total_price']
        ];

        $this->bookingModel->update($id, $data);
        header("Location: index.php?act=bookings");
    }

    public function delete() {
        $id = $_GET['id'];
        $this->bookingModel->delete($id);
        header("Location: index.php?act=bookings");
    }
}
