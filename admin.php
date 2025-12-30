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

// Generate Users HTML
$userRows = '';
foreach ($allUsers as $user) {
    $userRows .= '<tr>
        <td>' . $user['id'] . '</td>
        <td>' . htmlspecialchars($user['username']) . '</td>
        <td>' . htmlspecialchars($user['email']) . '</td>
        <td><a href="edit_user.php?id=' . $user['id'] . '">Edit</a> | <a href="delete_user.php?id=' . $user['id'] . '" class="delete-btn">Delete</a></td>
    </tr>';
}

// Generate Items HTML
$itemRows = '';
foreach ($allWellnessItems as $item) {
    $itemRows .= '<tr>
        <td>' . $item['id'] . '</td>
        <td>' . htmlspecialchars($item['name']) . '</td>
        <td>$' . number_format($item['price'], 2) . '</td>
        <td>' . $item['stock'] . '</td>
        <td><a href="edit_item.php?id=' . $item['id'] . '">Edit</a> | <a href="delete_item.php?id=' . $item['id'] . '" class="delete-btn">Delete</a></td>
    </tr>';
}

// Generate Transactions HTML
$transactionRows = '';
foreach ($recentTransactions as $transaction) {
    $transactionRows .= '<tr>
        <td>' . $transaction['id'] . '</td>
        <td>' . htmlspecialchars($transaction['username']) . '</td>
        <td>' . htmlspecialchars($transaction['item_name']) . '</td>
        <td>' . $transaction['quantity'] . '</td>
        <td>$' . number_format($transaction['total_price'], 2) . '</td>
        <td>' . $transaction['transaction_date'] . '</td>
    </tr>';
}

$template = file_get_contents('admin.html');
$template = str_replace('{{totalUsers}}', $totalUsers, $template);
$template = str_replace('{{totalWellnessItems}}', $totalWellnessItems, $template);
$template = str_replace('{{totalTransactions}}', $totalTransactions, $template);
$template = str_replace('{{totalRevenue}}', number_format($totalRevenue, 2), $template);
$template = str_replace('{{user_rows}}', $userRows, $template);
$template = str_replace('{{item_rows}}', $itemRows, $template);
$template = str_replace('{{transaction_rows}}', $transactionRows, $template);

echo $template;
?>
