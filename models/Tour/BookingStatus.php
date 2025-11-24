<?php
class BookingStatus {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function allByBooking($booking_id) {
        $stmt = $this->db->prepare("
            SELECT * FROM booking_status
            WHERE booking_id = ?
            ORDER BY created_at DESC
        ");
        $stmt->execute([$booking_id]);
        return $stmt->fetchAll();
    }

    public function create($data) {
        $sql = "INSERT INTO booking_status (booking_id, status_text)
                VALUES (?, ?)";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['booking_id'],
            $data['status_text']
        ]);
    }
}
