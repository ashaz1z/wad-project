<?php
include 'config/db_connect.php';

// Create Transaction
function createTransaction($user_id, $item_id, $quantity, $total_price) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO transactions (user_id, item_id, quantity, total_price) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiid", $user_id, $item_id, $quantity, $total_price);
    return $stmt->execute();
}

// Get Transaction by ID
function getTransactionById($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT id, user_id, item_id, quantity, total_price, transaction_date FROM transactions WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// Get all Transactions
function getAllTransactions() {
    global $conn;
    $result = $conn->query("SELECT id, user_id, item_id, quantity, total_price, transaction_date FROM transactions");
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Get all Transactions for a specific user
function getTransactionsByUserId($user_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT id, user_id, item_id, quantity, total_price, transaction_date FROM transactions WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}


// Delete Transaction
function deleteTransaction($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM transactions WHERE id = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}
?>
