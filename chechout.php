<?php
session_start();
require 'db.php';

$products = [
    1 => ["name" => "Product A", "price" => 10],
    2 => ["name" => "Product B", "price" => 15],
    3 => ["name" => "Product C", "price" => 20],
];

if (empty($_SESSION['cart'])) {
    header("Location: index.php");
    exit;
}

$total = 0;
$items = [];

foreach ($_SESSION['cart'] as $id => $qty) {
    $subtotal = $products[$id]['price'] * $qty;
    $total += $subtotal;
    $items[] = $products[$id]['name'] . " x $qty";
}

$db->prepare("INSERT INTO transactions (items, total) VALUES (?, ?)")
   ->execute([implode(", ", $items), $total]);

$_SESSION['cart'] = [];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Receipt</title>
</head>
<body>
<h2>Receipt</h2>

<p><strong>Items:</strong> <?= implode(", ", $items) ?></p>
<p><strong>Total Paid:</strong> $<?= $total ?></p>

<hr>
<a href="index.php">Back to Dashboard</a>
</body>
</html>
