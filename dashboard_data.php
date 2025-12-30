<?php
include 'config/db_connect.php';

// Get total number of users
function getTotalUsers() {
    global $conn;
    $result = $conn->query("SELECT COUNT(*) as total_users FROM users");
    return $result->fetch_assoc()['total_users'];
}

// Get total number of wellness items
function getTotalWellnessItems() {
    global $conn;
    $result = $conn->query("SELECT COUNT(*) as total_items FROM wellness_items");
    return $result->fetch_assoc()['total_items'];
}

// Get total number of transactions
function getTotalTransactions() {
    global $conn;
    $result = $conn->query("SELECT COUNT(*) as total_transactions FROM transactions");
    return $result->fetch_assoc()['total_transactions'];
}

// Get total revenue from transactions
function getTotalRevenue() {
    global $conn;
    $result = $conn->query("SELECT SUM(total_price) as total_revenue FROM transactions");
    return $result->fetch_assoc()['total_revenue'];
}

// Get recent transactions
function getRecentTransactions($limit = 5) {
    global $conn;
    $stmt = $conn->prepare("SELECT t.id, u.username, w.name as item_name, t.quantity, t.total_price, t.transaction_date FROM transactions t JOIN users u ON t.user_id = u.id JOIN wellness_items w ON t.item_id = w.id ORDER BY t.transaction_date DESC LIMIT ?");
    $stmt->bind_param("i", $limit);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}
?>
