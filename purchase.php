<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit();
}

include 'wellness_actions.php'; // Include this to get access to decrementStock
include 'transaction_actions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $item_id = $_POST['item_id'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $total_price = $quantity * $price;

    // Check stock first
    $item = getWellnessItemById($item_id);
    
    if ($item && $item['stock'] >= $quantity) {
        // Decrement stock
        decrementStock($item_id, $quantity);
        // Create transaction
        createTransaction($user_id, $item_id, $quantity, $total_price);
    } else {
        // Handle out of stock error (optional: redirect with error message)
    }
}

header('Location: dashboard.php#transaction-history');
exit();
?>
