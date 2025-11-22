<?php

class PaymentReminderController
{
    private $model;

    public function __construct($db)
    {
        $this->model = new PaymentReminder($db);
    }

    public function index()
    {
        $reminders = $this->model->getAll();
        require PATH_ROOT . 'views/payment_reminder/index.php';
    }

    public function create()
    {
        require PATH_ROOT . 'views/payment_reminder/create.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?controller=paymentReminder&action=index");
            exit;
        }

        $data = [
            'supplier_id' => $_POST['supplier_id'] ?? null,
            'contract_id' => $_POST['contract_id'] ?? null,
            'amount' => $_POST['amount'] ?? null,
            'due_date' => $_POST['due_date'] ?? null,
            'note' => $_POST['note'] ?? null
        ];

        $this->model->create($data);
        header("Location: index.php?controller=paymentReminder&action=index");
        exit;
    }

    public function autoCheck()
    {
        $dueToday = $this->model->getDueToday();
        $overdue = $this->model->getOverdue();

        foreach ($dueToday as $item) {
            $this->model->updateStatus($item['id'], "sent");
        }

        foreach ($overdue as $item) {
            $this->model->updateStatus($item['id'], "overdue");
        }

        echo json_encode([
            'success' => true,
            'message' => 'Auto payment reminder executed!',
            'due_today' => count($dueToday),
            'overdue' => count($overdue)
        ]);
    }
}
