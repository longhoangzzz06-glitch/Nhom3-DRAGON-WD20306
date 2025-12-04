<?php
session_start();
ob_start();
?>
<?php require_once './views/chung/index.php'; ?>
<?php
ob_end_flush();
?>
