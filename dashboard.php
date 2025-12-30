<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit();
}

include 'transaction_actions.php';

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

// Get summary data
$spendingData = getUserSpendingData($user_id);
$totalSpent = 0;
$recentActivity = getTransactionsByUserId($user_id);
$transactionCount = count($recentActivity);

// Calculate total spent
foreach ($recentActivity as $t) {
    $totalSpent += $t['total_price'];
}

// Prepare chart data
$chartLabels = [];
$chartValues = [];
foreach ($spendingData as $day) {
    $chartLabels[] = $day['date'];
    $chartValues[] = $day['daily_total'];
}

// Mock data for Fitness Progress (e.g., Weight over weeks)
$progressLabels = ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5', 'Week 6'];
$progressValues = [85, 84.2, 83.5, 82.8, 82.1, 81.5];

include 'dashboard_view.php';
?>
