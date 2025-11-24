<?php
class SpecialNote {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function allByBooking($booking_id) {
        $stmt = $this->db->prepare("
            SELECT * FROM special_notes
            WHERE booking_id = ?
            ORDER BY id DESC
        ");
        $stmt->execute([$booking_id]);
        return $stmt->fetchAll();
    }

    public function create($data) {
        $sql = "INSERT INTO special_notes (booking_id, note_text)
                VALUES (?, ?)";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['booking_id'],
            $data['note_text']
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM special_notes WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
