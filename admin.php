<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.html');
    exit();
}

include 'user_actions.php';
include 'wellness_actions.php';
include 'transaction_actions.php';
include 'dashboard_data.php';

$totalUsers = getTotalUsers();
$totalWellnessItems = getTotalWellnessItems();
$totalTransactions = getTotalTransactions();
$totalRevenue = getTotalRevenue();
$recentTransactions = getRecentTransactions();
$allUsers = getAllUsers();
$allWellnessItems = getAllWellnessItems();

include 'admin.html';
?>
