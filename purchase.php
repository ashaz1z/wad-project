<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit();
}

include 'transaction_actions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $item_id = $_POST['item_id'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $total_price = $quantity * $price;

    createTransaction($user_id, $item_id, $quantity, $total_price);
}

header('Location: dashboard.php#transaction-history');
exit();
?>
