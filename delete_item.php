<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.html');
    exit();
}

include 'wellness_actions.php';

if (isset($_GET['id'])) {
    $item_id = $_GET['id'];
    deleteWellnessItem($item_id);
}

header('Location: admin.php#manage-wellness-items');
exit();
?>
