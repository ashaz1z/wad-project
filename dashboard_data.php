include 'config/db_connect.php';
=======
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

// Get transactions filtered by period
function getTransactionsByPeriod($period) {
    global $conn;
    $query = "";
    switch ($period) {
        case 'daily':
            $query = "SELECT t.id, u.username, w.name as item_name, t.quantity, t.total_price, t.transaction_date FROM transactions t JOIN users u ON t.user_id = u.id JOIN wellness_items w ON t.item_id = w.id WHERE DATE(t.transaction_date) = CURDATE() ORDER BY t.transaction_date DESC";
            break;
        case 'weekly':
            $query = "SELECT t.id, u.username, w.name as item_name, t.quantity, t.total_price, t.transaction_date FROM transactions t JOIN users u ON t.user_id = u.id JOIN wellness_items w ON t.item_id = w.id WHERE YEARWEEK(t.transaction_date) = YEARWEEK(CURDATE()) ORDER BY t.transaction_date DESC";
            break;
        case 'monthly':
            $query = "SELECT t.id, u.username, w.name as item_name, t.quantity, t.total_price, t.transaction_date FROM transactions t JOIN users u ON t.user_id = u.id JOIN wellness_items w ON t.item_id = w.id WHERE YEAR(t.transaction_date) = YEAR(CURDATE()) AND MONTH(t.transaction_date) = MONTH(CURDATE()) ORDER BY t.transaction_date DESC";
            break;
        default:
            return getRecentTransactions(50); // Default to recent 50
    }
    $result = $conn->query($query);
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Get revenue data for charts (last 30 days)
function getRevenueData($days = 30) {
    global $conn;
    $stmt = $conn->prepare("SELECT DATE(transaction_date) as date, SUM(total_price) as revenue FROM transactions WHERE transaction_date >= DATE_SUB(CURDATE(), INTERVAL ? DAY) GROUP BY DATE(transaction_date) ORDER BY date");
    $stmt->bind_param("i", $days);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

// Get user growth data (last 30 days)
function getUserGrowthData($days = 30) {
    global $conn;
    $stmt = $conn->prepare("SELECT DATE(created_at) as date, COUNT(*) as new_users FROM users WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL ? DAY) GROUP BY DATE(created_at) ORDER BY date");
    $stmt->bind_param("i", $days);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

// Get transaction volume data (last 30 days)
function getTransactionVolumeData($days = 30) {
    global $conn;
    $stmt = $conn->prepare("SELECT DATE(transaction_date) as date, COUNT(*) as transactions FROM transactions WHERE transaction_date >= DATE_SUB(CURDATE(), INTERVAL ? DAY) GROUP BY DATE(transaction_date) ORDER BY date");
    $stmt->bind_param("i", $days);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

// Get summary statistics for reports
function getTransactionSummary($period) {
    global $conn;
    $query = "";
    switch ($period) {
        case 'daily':
            $query = "SELECT COUNT(*) as total_transactions, SUM(total_price) as total_revenue, AVG(total_price) as avg_transaction FROM transactions WHERE DATE(transaction_date) = CURDATE()";
            break;
        case 'weekly':
            $query = "SELECT COUNT(*) as total_transactions, SUM(total_price) as total_revenue, AVG(total_price) as avg_transaction FROM transactions WHERE YEARWEEK(transaction_date) = YEARWEEK(CURDATE())";
            break;
        case 'monthly':
            $query = "SELECT COUNT(*) as total_transactions, SUM(total_price) as total_revenue, AVG(total_price) as avg_transaction FROM transactions WHERE YEAR(transaction_date) = YEAR(CURDATE()) AND MONTH(transaction_date) = MONTH(CURDATE())";
            break;
        default:
            $query = "SELECT COUNT(*) as total_transactions, SUM(total_price) as total_revenue, AVG(total_price) as avg_transaction FROM transactions";
    }
    $result = $conn->query($query);
    return $result->fetch_assoc();
}

// Helper functions for chart data
function getRevenueChartData() {
    $data = getRevenueData();
    $labels = [];
    $values = [];
    foreach ($data as $row) {
        $labels[] = $row['date'];
        $values[] = (float)$row['revenue'];
    }
    return ['labels' => $labels, 'data' => $values];
}

function getUserGrowthChartData() {
    $data = getUserGrowthData();
    $labels = [];
    $values = [];
    foreach ($data as $row) {
        $labels[] = $row['date'];
        $values[] = (int)$row['new_users'];
    }
    return ['labels' => $labels, 'data' => $values];
}

function getTransactionVolumeChartData() {
    $data = getTransactionVolumeData();
    $labels = [];
    $values = [];
    foreach ($data as $row) {
        $labels[] = $row['date'];
        $values[] = (int)$row['transactions'];
    }
    return ['labels' => $labels, 'data' => $values];
}

// Export function
function exportTransactions($period) {
    $transactions = getTransactionsByPeriod($period);

    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="transactions_' . $period . '.csv"');

    $output = fopen('php://output', 'w');
    fputcsv($output, ['ID', 'Username', 'Item Name', 'Quantity', 'Total Price', 'Transaction Date']);

    foreach ($transactions as $transaction) {
        fputcsv($output, [
            $transaction['id'],
            $transaction['username'],
            $transaction['item_name'],
            $transaction['quantity'],
            $transaction['total_price'],
            $transaction['transaction_date']
        ]);
    }

    fclose($output);
    exit;
}


