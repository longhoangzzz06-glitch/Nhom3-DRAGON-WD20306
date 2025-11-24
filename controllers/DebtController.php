<?php

class DebtController
{
    private $model;
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
        $this->model = new DebtModel($db);
    }

    public function index()
    {
        try {
            $debts = $this->model->getAllDebts();
            $outstanding = $this->model->getOutstandingDebts();
            $upcoming = $this->model->getUpcomingDebts(7);

            require PATH_ROOT . 'views/debt/list.php';
        } catch (Exception $e) {
            header('HTTP/1.1 500 Internal Server Error');
            echo "Lỗi: " . htmlspecialchars($e->getMessage());
            exit;
        }
    }

    public function create()
    {
        require PATH_ROOT . 'views/debt/create.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?act=debt-list');
            exit;
        }

        $id = $_POST['id'] ?? null;
        $loai = $_POST['loai'] ?? null;
        $doi_tuong = $_POST['doi_tuong'] ?? null;
        $so_tien = $_POST['so_tien'] ?? null;
        $han_thanh_toan = $_POST['han_thanh_toan'] ?? null;
        $note = $_POST['note'] ?? null;

        if (empty($loai) || empty($doi_tuong) || empty($so_tien)) {
            header('Location: index.php?act=debt-create&error=missing_fields');
            exit;
        }

        try {
            $data = [
                'loai' => $loai,
                'doi_tuong' => $doi_tuong,
                'so_tien' => (float) str_replace([',', ' '], ['', ''], $so_tien),
                'han_thanh_toan' => $han_thanh_toan,
                'note' => $note
            ];

            if ($id) {
                $this->model->updateDebt($id, $data);
            } else {
                $this->model->createDebt($data);
            }

            header('Location: index.php?act=debt-list');
            exit;
        } catch (Exception $e) {
            header('Location: index.php?act=debt-create&error=db');
            exit;
        }
    }

    public function detail()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?act=debt-list');
            exit;
        }

        try {
            $debt = $this->model->getDebtById($id);
            if (!$debt) {
                header('HTTP/1.1 404 Not Found');
                echo "Công nợ không tồn tại";
                exit;
            }

            $payments = $this->model->getPayments($id);
            require PATH_ROOT . 'views/debt/detail.php';
        } catch (Exception $e) {
            header('HTTP/1.1 500 Internal Server Error');
            echo "Lỗi: " . htmlspecialchars($e->getMessage());
            exit;
        }
    }

    public function savePayment()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?act=debt-list');
            exit;
        }

        $debt_id = $_POST['debt_id'] ?? null;
        $amount = $_POST['amount'] ?? null;
        $note = $_POST['note'] ?? null;

        if (!$debt_id || !$amount) {
            header('Location: index.php?act=debt-detail&id=' . $debt_id . '&error=missing_fields');
            exit;
        }

        try {
            $amount = (float) str_replace([',', ' '], ['', ''], $amount);
            $this->model->addPayment($debt_id, $amount, $note);
            header('Location: index.php?act=debt-detail&id=' . $debt_id . '&success=1');
            exit;
        } catch (Exception $e) {
            header('Location: index.php?act=debt-detail&id=' . $debt_id . '&error=payment_failed');
            exit;
        }
    }

    public function delete()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?act=debt-list');
            exit;
        }

        try {
            $this->model->deleteDebt($id);
            header('Location: index.php?act=debt-list&success=deleted');
            exit;
        } catch (Exception $e) {
            header('Location: index.php?act=debt-list&error=delete_failed');
            exit;
        }
    }

    public function outstanding()
    {
        try {
            $debts = $this->model->getOutstandingDebts();
            require PATH_ROOT . 'views/debt/outstanding.php';
        } catch (Exception $e) {
            header('HTTP/1.1 500 Internal Server Error');
            echo "Lỗi: " . htmlspecialchars($e->getMessage());
            exit;
        }
    }

    public function upcoming()
    {
        $days = $_GET['days'] ?? 7;
        try {
            $debts = $this->model->getUpcomingDebts((int)$days);
            require PATH_ROOT . 'views/debt/upcoming.php';
        } catch (Exception $e) {
            header('HTTP/1.1 500 Internal Server Error');
            echo "Lỗi: " . htmlspecialchars($e->getMessage());
            exit;
        }
    }
}
