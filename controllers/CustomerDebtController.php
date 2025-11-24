<?php

class CustomerDebtController
{
    private $model;
    private $db;

    public function __construct($db)
    {
        if (!($db instanceof PDO)) {
            throw new InvalidArgumentException("Constructor requires PDO instance");
        }
        $this->db = $db;
        $this->model = new CustomerDebt($db);
    }

    public function index()
    {
        try {
            $page = max(1, (int)($_GET['page'] ?? 1));
            $limit = 20;
            $offset = ($page - 1) * $limit;

            $debts = $this->model->getAll();
            $total = count($debts); // Or implement countAll() in model
            $totalPages = ceil($total / $limit);

            require PATH_ROOT . 'views/customer_debts/index.php';
        } catch (Exception $e) {
            header('HTTP/1.1 500 Internal Server Error');
            echo "Lỗi: " . htmlspecialchars($e->getMessage());
            exit;
        }
    }

    public function create()
    {
        try {
            // GET request: show form
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                // Load customers and tours for dropdowns
                $stmt = $this->db->query("SELECT id, customer_name FROM customers ORDER BY customer_name");
                $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $stmt = $this->db->query("SELECT id, tour_name FROM tours ORDER BY tour_name");
                $tours = $stmt->fetchAll(PDO::FETCH_ASSOC);

                require PATH_ROOT . 'views/customer_debts/create.php';
                return;
            }

            // POST request: store data
            $customer_id = $_POST['customer_id'] ?? null;
            $tour_id = $_POST['tour_id'] ?? null;
            $total_price = $_POST['total_price'] ?? null;
            $paid_amount = $_POST['paid_amount'] ?? 0;

            if (empty($customer_id) || empty($tour_id) || empty($total_price)) {
                header('Location: index.php?act=customer-debt-create&error=missing_fields');
                exit;
            }

            $data = [
                'customer_id' => $customer_id,
                'tour_id' => $tour_id,
                'total_price' => (float) str_replace([',', ' '], ['', ''], $total_price),
                'paid_amount' => (float) str_replace([',', ' '], ['', ''], $paid_amount),
                'last_payment_date' => $_POST['last_payment_date'] ?? null,
                'note' => $_POST['note'] ?? null
            ];

            $this->model->create($data);
            header('Location: index.php?act=customer-debts&success=created');
            exit;
        } catch (Exception $e) {
            header('Location: index.php?act=customer-debt-create&error=db');
            exit;
        }
    }

    public function edit()
    {
        try {
            $id = $_GET['id'] ?? null;
            if (!$id) {
                header('Location: index.php?act=customer-debts');
                exit;
            }

            $debt = $this->model->getById($id);
            if (!$debt) {
                header('HTTP/1.1 404 Not Found');
                echo "Công nợ không tồn tại";
                exit;
            }

            // GET request: show form
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                // Load customers and tours for dropdowns
                $stmt = $this->db->query("SELECT id, customer_name FROM customers ORDER BY customer_name");
                $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $stmt = $this->db->query("SELECT id, tour_name FROM tours ORDER BY tour_name");
                $tours = $stmt->fetchAll(PDO::FETCH_ASSOC);

                require PATH_ROOT . 'views/customer_debts/edit.php';
                return;
            }

            // POST request: update data
            $customer_id = $_POST['customer_id'] ?? null;
            $tour_id = $_POST['tour_id'] ?? null;
            $total_price = $_POST['total_price'] ?? null;
            $paid_amount = $_POST['paid_amount'] ?? 0;

            if (empty($customer_id) || empty($tour_id) || empty($total_price)) {
                header('Location: index.php?act=customer-debt-edit&id=' . $id . '&error=missing_fields');
                exit;
            }

            $data = [
                'customer_id' => $customer_id,
                'tour_id' => $tour_id,
                'total_price' => (float) str_replace([',', ' '], ['', ''], $total_price),
                'paid_amount' => (float) str_replace([',', ' '], ['', ''], $paid_amount),
                'last_payment_date' => $_POST['last_payment_date'] ?? null,
                'note' => $_POST['note'] ?? null
            ];

            $this->model->update($id, $data);
            header('Location: index.php?act=customer-debts&success=updated');
            exit;
        } catch (Exception $e) {
            header('HTTP/1.1 500 Internal Server Error');
            echo "Lỗi: " . htmlspecialchars($e->getMessage());
            exit;
        }
    }

    public function delete()
    {
        try {
            $id = $_GET['id'] ?? null;
            if (!$id) {
                header('Location: index.php?act=customer-debts');
                exit;
            }

            $this->model->delete($id);
            header('Location: index.php?act=customer-debts&success=deleted');
            exit;
        } catch (Exception $e) {
            header('Location: index.php?act=customer-debts&error=delete_failed');
            exit;
        }
    }

    public function addPayment()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                header('Location: index.php?act=customer-debts');
                exit;
            }

            $debt_id = $_POST['debt_id'] ?? null;
            $amount = $_POST['amount'] ?? null;

            if (!$debt_id || !$amount) {
                header('Location: index.php?act=customer-debt-detail&id=' . $debt_id . '&error=missing_fields');
                exit;
            }

            $amount = (float) str_replace([',', ' '], ['', ''], $amount);
            $this->model->addPayment($debt_id, $amount);

            header('Location: index.php?act=customer-debt-detail&id=' . $debt_id . '&success=payment_added');
            exit;
        } catch (Exception $e) {
            header('Location: index.php?act=customer-debt-detail&id=' . $_POST['debt_id'] . '&error=' . urlencode($e->getMessage()));
            exit;
        }
    }

    public function detail()
    {
        try {
            $id = $_GET['id'] ?? null;
            if (!$id) {
                header('Location: index.php?act=customer-debts');
                exit;
            }

            $debt = $this->model->getById($id);
            if (!$debt) {
                header('HTTP/1.1 404 Not Found');
                echo "Công nợ không tồn tại";
                exit;
            }

            require PATH_ROOT . 'views/customer_debts/detail.php';
        } catch (Exception $e) {
            header('HTTP/1.1 500 Internal Server Error');
            echo "Lỗi: " . htmlspecialchars($e->getMessage());
            exit;
        }
    }

    public function outstanding()
    {
        try {
            $debts = $this->model->getOutstandingDebts();
            require PATH_ROOT . 'views/customer_debts/outstanding.php';
        } catch (Exception $e) {
            header('HTTP/1.1 500 Internal Server Error');
            echo "Lỗi: " . htmlspecialchars($e->getMessage());
            exit;
        }
    }
}
