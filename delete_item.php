<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    if (isset($_GET['ajax'])) {
        echo json_encode(['success' => false, 'message' => 'Unauthorized']);
        exit();
    }
    header('Location: login.html');
    exit();
}

include 'wellness_actions.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = deleteWellnessItem($id);
    
    if (isset($_GET['ajax'])) {
        header('Content-Type: application/json');
        echo json_encode(['success' => $result]);
        exit();
    }
}

header('Location: admin.php#manage-wellness-items');
exit();
?>