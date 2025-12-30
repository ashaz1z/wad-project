<?php
session_start();

$products = [
    1 => ["name" => "Product A", "price" => 10],
    2 => ["name" => "Product B", "price" => 15],
    3 => ["name" => "Product C", "price" => 20],
];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Your Cart</title>
</head>
<body>
<h2>Your Cart</h2>
<a href="index.php">⬅ Back</a>

<hr>

<?php
$total = 0;
if (empty($_SESSION['cart'])) {
    echo "Cart is empty.";
} else {
    foreach ($_SESSION['cart'] as $id => $qty) {
        $subtotal = $products[$id]['price'] * $qty;
        $total += $subtotal;
        echo "{$products[$id]['name']} x $qty = $$subtotal<br>";
    }
    echo "<hr><strong>Total: $$total</strong><br><br>";
    echo "<a href='checkout.php'>Checkout</a>";
}
?>
</body>
</html>
