<?php
session_start();

$products = [
    1 => ["name" => "Product A", "price" => 10],
    2 => ["name" => "Product B", "price" => 15],
    3 => ["name" => "Product C", "price" => 20],
];

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_GET['add'])) {
    $id = $_GET['add'];
    $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + 1;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Member Dashboard</title>
</head>
<body>
<h2>Member Dashboard</h2>
<a href="cart.php">🛒 View Cart</a> |
<a href="history.php">📜 Transaction History</a>

<hr>

<h3>Products</h3>
<?php foreach ($products as $id => $p): ?>
    <p>
        <?= $p['name'] ?> - $<?= $p['price'] ?>
        <a href="?add=<?= $id ?>">Add to Cart</a>
    </p>
<?php endforeach; ?>
</body>
</html>
