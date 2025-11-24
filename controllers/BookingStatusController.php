<?php
class BookingStatusController {
    private $db;
    private $statusModel;

    public function __construct($db) {
        $this->db = $db;
        $this->statusModel = new BookingStatus($db);
    }

    public function store() {
        $data = [
            'booking_id' => $_POST['booking_id'],
            'status_text' => $_POST['status_text']
        ];

        $this->statusModel->create($data);
        header("Location: index.php?act=booking-detail&id=" . $_POST['booking_id']);
    }
}
