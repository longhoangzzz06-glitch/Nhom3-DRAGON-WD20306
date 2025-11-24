<?php

class SupplierDebtController
{
    private $model;
    private $db;

    public function __construct($db)
    {
        if (!($db instanceof PDO)) {
            throw new InvalidArgumentException("Constructor requires PDO instance");
        }
        $this->db = $db;
        $this->model = new SupplierDebt($db);
    }

    public function index()
    {
        try {
            $page = max(1, (int)($_GET['page'] ?? 1));
            $limit = 20;
            $offset = ($page - 1) * $limit;

            $debts = $this->model->getAll();
            $total = count($debts);
            $totalPages = ceil($total / $limit);

            require PATH_ROOT . 'views/supplier_debts/index.php';
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
                // Load suppliers and contracts for dropdowns
                $stmt = $this->db->query("SELECT id, name FROM suppliers ORDER BY name");
                $suppliers = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $stmt = $this->db->query("SELECT id, title FROM supplier_contracts ORDER BY title");
                $contracts = $stmt->fetchAll(PDO::FETCH_ASSOC);

                require PATH_ROOT . 'views/supplier_debts/create.php';
                return;
            }

            // POST request: store data
            $supplier_id = $_POST['supplier_id'] ?? null;
            $contract_id = $_POST['contract_id'] ?? null;
            $total_cost = $_POST['total_cost'] ?? null;

            if (empty($supplier_id) || empty($total_cost)) {
                header('Location: index.php?act=supplier-debt-create&error=missing_fields');
                exit;
            }

            $data = [
                'supplier_id' => $supplier_id,
                'contract_id' => $contract_id,
                'total_cost' => (float) str_replace([',', ' '], ['', ''], $total_cost),
                'paid_amount' => (float) str_replace([',', ' '], ['', ''], $_POST['paid_amount'] ?? 0),
                'last_payment_date' => $_POST['last_payment_date'] ?? null,
                'note' => $_POST['note'] ?? null
            ];

            $this->model->create($data);
            header('Location: index.php?act=supplier-debts&success=created');
            exit;
        } catch (Exception $e) {
            header('Location: index.php?act=supplier-debt-create&error=db');
            exit;
        }
    }

    public function edit()
    {
        try {
            $id = $_GET['id'] ?? null;
            if (!$id) {
                header('Location: index.php?act=supplier-debts');
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
                // Load suppliers and contracts for dropdowns
                $stmt = $this->db->query("SELECT id, name FROM suppliers ORDER BY name");
                $suppliers = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $stmt = $this->db->query("SELECT id, title FROM supplier_contracts ORDER BY title");
                $contracts = $stmt->fetchAll(PDO::FETCH_ASSOC);

                require PATH_ROOT . 'views/supplier_debts/edit.php';
                return;
            }

            // POST request: update data
            $supplier_id = $_POST['supplier_id'] ?? null;
            $contract_id = $_POST['contract_id'] ?? null;
            $total_cost = $_POST['total_cost'] ?? null;

            if (empty($supplier_id) || empty($total_cost)) {
                header('Location: index.php?act=supplier-debt-edit&id=' . $id . '&error=missing_fields');
                exit;
            }

            $data = [
                'supplier_id' => $supplier_id,
                'contract_id' => $contract_id,
                'total_cost' => (float) str_replace([',', ' '], ['', ''], $total_cost),
                'paid_amount' => (float) str_replace([',', ' '], ['', ''], $_POST['paid_amount'] ?? 0),
                'last_payment_date' => $_POST['last_payment_date'] ?? null,
                'note' => $_POST['note'] ?? null
            ];

            $this->model->update($id, $data);
            header('Location: index.php?act=supplier-debts&success=updated');
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
                header('Location: index.php?act=supplier-debts');
                exit;
            }

            $this->model->delete($id);
            header('Location: index.php?act=supplier-debts&success=deleted');
            exit;
        } catch (Exception $e) {
            header('Location: index.php?act=supplier-debts&error=delete_failed');
            exit;
        }
    }

    public function detail()
    {
        try {
            $id = $_GET['id'] ?? null;
            if (!$id) {
                header('Location: index.php?act=supplier-debts');
                exit;
            }

            $debt = $this->model->getById($id);
            if (!$debt) {
                header('HTTP/1.1 404 Not Found');
                echo "Công nợ không tồn tại";
                exit;
            }

            require PATH_ROOT . 'views/supplier_debts/detail.php';
        } catch (Exception $e) {
            header('HTTP/1.1 500 Internal Server Error');
            echo "Lỗi: " . htmlspecialchars($e->getMessage());
            exit;
        }
    }

    public function addPayment()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                header('Location: index.php?act=supplier-debts');
                exit;
            }

            $debt_id = $_POST['debt_id'] ?? null;
            $amount = $_POST['amount'] ?? null;

            if (!$debt_id || !$amount) {
                header('Location: index.php?act=supplier-debt-detail&id=' . $debt_id . '&error=missing_fields');
                exit;
            }

            $amount = (float) str_replace([',', ' '], ['', ''], $amount);
            $this->model->addPayment($debt_id, $amount);

            header('Location: index.php?act=supplier-debt-detail&id=' . $debt_id . '&success=payment_added');
            exit;
        } catch (Exception $e) {
            header('Location: index.php?act=supplier-debt-detail&id=' . $_POST['debt_id'] . '&error=' . urlencode($e->getMessage()));
            exit;
        }
    }

    public function outstanding()
    {
        try {
            $debts = $this->model->getOutstandingDebts();
            require PATH_ROOT . 'views/supplier_debts/outstanding.php';
        } catch (Exception $e) {
            header('HTTP/1.1 500 Internal Server Error');
            echo "Lỗi: " . htmlspecialchars($e->getMessage());
            exit;
        }
    }
}
