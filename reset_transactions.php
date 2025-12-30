<?php
include 'config/db_connect.php';

// Clear all data from the transactions table
if ($conn->query("TRUNCATE TABLE transactions") === TRUE) {
    echo "All random transactions have been deleted. <a href='admin.php'>Return to Dashboard</a>";
} else {
    echo "Error clearing transactions: " . $conn->error;
}
?>