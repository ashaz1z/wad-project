<?php
include 'config/db_connect.php';

// Insert sample users
$users = [
    ['username' => 'admin', 'password' => 'admin123', 'email' => 'admin@fitflow.com'],
    ['username' => 'john_doe', 'password' => 'password123', 'email' => 'john@example.com'],
    ['username' => 'jane_smith', 'password' => 'password123', 'email' => 'jane@example.com'],
    ['username' => 'mike_jones', 'password' => 'password123', 'email' => 'mike@example.com'],
    ['username' => 'sarah_wilson', 'password' => 'password123', 'email' => 'sarah@example.com']
];

foreach ($users as $user) {
    $hashed_password = password_hash($user['password'], PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $user['username'], $hashed_password, $user['email']);
    $stmt->execute();
    echo "Inserted user: " . $user['username'] . "\n";
}

// Insert sample wellness items
$items = [
    ['name' => 'Yoga Mat', 'description' => 'High-quality yoga mat for all your fitness needs', 'price' => 29.99],
    ['name' => 'Dumbbells Set', 'description' => 'Adjustable dumbbells for strength training', 'price' => 49.99],
    ['name' => 'Resistance Bands', 'description' => 'Set of resistance bands for home workouts', 'price' => 19.99],
    ['name' => 'Protein Powder', 'description' => 'Whey protein powder for muscle recovery', 'price' => 39.99],
    ['name' => 'Foam Roller', 'description' => 'Foam roller for muscle recovery and massage', 'price' => 24.99]
];

foreach ($items as $item) {
    $stmt = $conn->prepare("INSERT INTO wellness_items (name, description, price) VALUES (?, ?, ?)");
    $stmt->bind_param("ssd", $item['name'], $item['description'], $item['price']);
    $stmt->execute();
    echo "Inserted item: " . $item['name'] . "\n";
}

// Get user IDs and item IDs for transactions
$user_ids = $conn->query("SELECT id FROM users")->fetch_all(MYSQLI_ASSOC);
$item_ids = $conn->query("SELECT id FROM wellness_items")->fetch_all(MYSQLI_ASSOC);

// Insert sample transactions

echo "Sample data inserted successfully!\n";
?>
