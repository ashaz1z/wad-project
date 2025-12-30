<?php
include 'config/db_connect.php';
include 'user_actions.php';
include 'transaction_actions.php';

// Test deleteUser function
// First, find a user who has transactions
$user_id = 2; // Assuming user ID 2 exists and has transactions

echo "Testing deleteUser for user ID: $user_id\n";

// Check if user exists
$user = getUserById($user_id);
if (!$user) {
    echo "User does not exist.\n";
    exit();
}

echo "User found: " . $user['username'] . "\n";

// Check transactions for this user using direct query
$result = $conn->query("SELECT COUNT(*) as count FROM transactions WHERE user_id = $user_id");
$row = $result->fetch_assoc();
$transaction_count = $row['count'];
echo "Number of transactions for this user: $transaction_count\n";

// Attempt to delete the user
$result = deleteUser($user_id);

if ($result) {
    echo "User deleted successfully!\n";
    // Verify user is deleted
    $user_after = getUserById($user_id);
    if (!$user_after) {
        echo "Verification: User no longer exists.\n";
    } else {
        echo "Verification failed: User still exists.\n";
    }
    // Verify transactions are deleted using direct query
    $result_after = $conn->query("SELECT COUNT(*) as count FROM transactions WHERE user_id = $user_id");
    $row_after = $result_after->fetch_assoc();
    $transaction_count_after = $row_after['count'];
    echo "Transactions after deletion: $transaction_count_after\n";
} else {
    echo "Failed to delete user.\n";
}
?>
