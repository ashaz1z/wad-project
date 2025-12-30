<?php
include 'config/db_connect.php';

// Add stock column if it doesn't exist
$sql = "SHOW COLUMNS FROM wellness_items LIKE 'stock'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    // Default stock is 10 for existing items
    $sql = "ALTER TABLE wellness_items ADD COLUMN stock INT DEFAULT 10"; 
    if ($conn->query($sql) === TRUE) {
        echo "Stock column added successfully. <a href='admin.php'>Go to Admin Dashboard</a>";
    } else {
        echo "Error adding stock column: " . $conn->error;
    }
} else {
    echo "Stock column already exists. <a href='admin.php'>Go to Admin Dashboard</a>";
}
?>