<?php

class SpecialNoteController
{
    private $db;
    private $noteModel;

    public function __construct($db)
    {
        if (!($db instanceof PDO)) {
            throw new InvalidArgumentException("Constructor requires PDO instance");
        }
        $this->db = $db;
        $this->noteModel = new SpecialNote($db);
    }

    public function index()
    {
        try {
            $booking_id = $_GET['booking_id'] ?? null;
            if (!$booking_id) {
                header('Location: index.php?act=bookings');
                exit;
            }

            $notes = $this->noteModel->getByBooking($booking_id);
            require PATH_ROOT . 'views/special_notes/index.php';
        } catch (Exception $e) {
            header('HTTP/1.1 500 Internal Server Error');
            echo "Lỗi: " . htmlspecialchars($e->getMessage());
            exit;
        }
    }

    public function create()
    {
        try {
            $booking_id = $_GET['booking_id'] ?? null;
            if (!$booking_id) {
                header('Location: index.php?act=bookings');
                exit;
            }

            // Verify booking exists
            $stmt = $this->db->prepare("SELECT id FROM bookings WHERE id = ?");
            $stmt->execute([$booking_id]);
            if (!$stmt->fetch()) {
                header('HTTP/1.1 404 Not Found');
                echo "Đặt tour không tồn tại";
                exit;
            }

            require PATH_ROOT . 'views/special_notes/create.php';
        } catch (Exception $e) {
            header('HTTP/1.1 500 Internal Server Error');
            echo "Lỗi: " . htmlspecialchars($e->getMessage());
            exit;
        }
    }

    public function store()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                header('Location: index.php?act=bookings');
                exit;
            }

            $booking_id = $_POST['booking_id'] ?? null;
            $note_text = $_POST['note_text'] ?? null;

            // Validation
            if (!$booking_id || empty($note_text)) {
                header('Location: index.php?act=special-note-create&booking_id=' . $booking_id . '&error=missing_fields');
                exit;
            }

            // Verify booking exists
            $stmt = $this->db->prepare("SELECT id FROM bookings WHERE id = ?");
            $stmt->execute([$booking_id]);
            if (!$stmt->fetch()) {
                header('HTTP/1.1 404 Not Found');
                echo "Đặt tour không tồn tại";
                exit;
            }

            $data = [
                'booking_id' => $booking_id,
                'note_text' => trim($note_text),
                'created_by' => $_SESSION['user_id'] ?? null
            ];

            $this->noteModel->create($data);
            header('Location: index.php?act=booking-detail&id=' . $booking_id . '&success=note_added');
            exit;
        } catch (Exception $e) {
            header('Location: index.php?act=special-note-create&booking_id=' . $_POST['booking_id'] . '&error=db');
            exit;
        }
    }

    public function update()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                header('Location: index.php?act=bookings');
                exit;
            }

            $id = $_POST['id'] ?? null;
            $booking_id = $_POST['booking_id'] ?? null;
            $note_text = $_POST['note_text'] ?? null;

            // Validation
            if (!$id || !$booking_id || empty($note_text)) {
                header('Location: index.php?act=special-note-edit&id=' . $id . '&booking_id=' . $booking_id . '&error=missing_fields');
                exit;
            }

            // Verify note exists
            $note = $this->noteModel->getById($id);
            if (!$note) {
                header('HTTP/1.1 404 Not Found');
                echo "Ghi chú không tồn tại";
                exit;
            }

            // Verify booking exists
            $stmt = $this->db->prepare("SELECT id FROM bookings WHERE id = ?");
            $stmt->execute([$booking_id]);
            if (!$stmt->fetch()) {
                header('HTTP/1.1 404 Not Found');
                echo "Đặt tour không tồn tại";
                exit;
            }

            $data = [
                'note_text' => trim($note_text)
            ];

            $this->noteModel->update($id, $data);
            header('Location: index.php?act=booking-detail&id=' . $booking_id . '&success=note_updated');
            exit;
        } catch (Exception $e) {
            header('Location: index.php?act=special-note-edit&id=' . $_POST['id'] . '&booking_id=' . $_POST['booking_id'] . '&error=db');
            exit;
        }
    }

    public function delete()
    {
        try {
            $id = $_GET['id'] ?? null;
            $booking_id = $_GET['booking_id'] ?? null;

            if (!$id || !$booking_id) {
                header('Location: index.php?act=bookings');
                exit;
            }

            // Verify note exists
            $note = $this->noteModel->getById($id);
            if (!$note) {
                header('HTTP/1.1 404 Not Found');
                echo "Ghi chú không tồn tại";
                exit;
            }

            // Verify booking exists
            $stmt = $this->db->prepare("SELECT id FROM bookings WHERE id = ?");
            $stmt->execute([$booking_id]);
            if (!$stmt->fetch()) {
                header('HTTP/1.1 404 Not Found');
                echo "Đặt tour không tồn tại";
                exit;
            }

            $this->noteModel->delete($id);
            header('Location: index.php?act=booking-detail&id=' . $booking_id . '&success=note_deleted');
            exit;
        } catch (Exception $e) {
            header('Location: index.php?act=booking-detail&id=' . $_GET['booking_id'] . '&error=delete_failed');
            exit;
        }
    }

    public function edit()
    {
        try {
            $id = $_GET['id'] ?? null;
            $booking_id = $_GET['booking_id'] ?? null;

            if (!$id || !$booking_id) {
                header('Location: index.php?act=bookings');
                exit;
            }

            $note = $this->noteModel->getById($id);
            if (!$note) {
                header('HTTP/1.1 404 Not Found');
                echo "Ghi chú không tồn tại";
                exit;
            }

            // Verify booking exists
            $stmt = $this->db->prepare("SELECT id FROM bookings WHERE id = ?");
            $stmt->execute([$booking_id]);
            if (!$stmt->fetch()) {
                header('HTTP/1.1 404 Not Found');
                echo "Đặt tour không tồn tại";
                exit;
            }

            require PATH_ROOT . 'views/special_notes/edit.php';
        } catch (Exception $e) {
            header('HTTP/1.1 500 Internal Server Error');
            echo "Lỗi: " . htmlspecialchars($e->getMessage());
            exit;
        }
    }
}
