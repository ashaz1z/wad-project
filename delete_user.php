<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.html');
    exit();
}

include 'user_actions.php';

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    deleteUser($user_id);
}

header('Location: admin.php#manage-users');
exit();
?>
