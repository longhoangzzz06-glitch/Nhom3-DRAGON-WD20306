<?php
// filepath: d:\FPT_Polytechnic\laragon\www\Duan\Nhom3-DRAGON-WD20306\views\paymentReminder\auto-payment-check.php

require PATH_ROOT . 'commons/env.php';
require PATH_ROOT . 'commons/function.php';

// Initialize database connection
$db = connectDB();

require PATH_ROOT . 'controllers/PaymentReminderController.php';

$controller = new PaymentReminderController($db);
$controller->autoCheck();
