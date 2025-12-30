<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit();
}

include 'transaction_actions.php';

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$userTransactions = getTransactionsByUserId($user_id);

$rowsHtml = '';
foreach ($userTransactions as $transaction) {
    $rowsHtml .= '
    <tr>
        <td>'.$transaction['id'].'</td>
        <td>'.$transaction['item_id'].'</td>
        <td>'.$transaction['quantity'].'</td>
        <td>$'.number_format($transaction['total_price'], 2).'</td>
        <td>'.$transaction['transaction_date'].'</td>
    </tr>';
}

$template = file_get_contents('member_history.html');
$template = str_replace('{{history_rows}}', $rowsHtml, $template);
echo $template;
?>