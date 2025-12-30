<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit();
}

include 'wellness_actions.php';
include 'transaction_actions.php';

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

$wellnessItems = getAllWellnessItems();
$userTransactions = getTransactionsByUserId($user_id);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Member Dashboard | FitFlow</title>
  <link rel="stylesheet" href="assets/css/main.css">
</head>
<body>
  <header>
    <a href="index.html"><img src="assets/img/FitFlowLogo.jpeg" alt="Logo" class="logo"></a>
    <h1>FitFlow</h1>
    <nav>
      <a href="index.html">Home</a>
      <a href="about.html">About</a>
      <a href="logout.php">Logout</a>
    </nav>
  </header>

  <div class="dashboard-layout">
    <aside class="sidebar">
      <h3>Member Panel</h3>
      <ul>
        <li><a href="#wellness-items">Wellness Items</a></li>
        <li><a href="#transaction-history">Transaction History</a></li>
      </ul>
    </aside>

    <main class="dashboard-main">
      <h2>Member Dashboard</h2>
      <p>Welcome, <?php echo $username; ?>!</p>

      <section id="wellness-items" class="dashboard-section">
        <h3>Wellness Items</h3>
        <div class="items-grid">
            <?php foreach ($wellnessItems as $item): ?>
            <div class="card">
                <h4><?php echo $item['name']; ?></h4>
                <p><?php echo $item['description']; ?></p>
                <p>Price: $<?php echo number_format($item['price'], 2); ?></p>
                <form action="purchase.php" method="post">
                    <input type="hidden" name="item_id" value="<?php echo $item['id']; ?>">
                    <input type="hidden" name="price" value="<?php echo $item['price']; ?>">
                    <label for="quantity-<?php echo $item['id']; ?>">Quantity:</label>
                    <input type="number" id="quantity-<?php echo $item['id']; ?>" name="quantity" value="1" min="1">
                    <button type="submit">Purchase</button>
                </form>
            </div>
            <?php endforeach; ?>
        </div>
      </section>

      <section id="transaction-history" class="dashboard-section">
        <h3>Transaction History</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Item ID</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($userTransactions as $transaction): ?>
                <tr>
                    <td><?php echo $transaction['id']; ?></td>
                    <td><?php echo $transaction['item_id']; ?></td>
                    <td><?php echo $transaction['quantity']; ?></td>
                    <td>$<?php echo number_format($transaction['total_price'], 2); ?></td>
                    <td><?php echo $transaction['transaction_date']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
      </section>
    </main>
  </div>

  <footer>
    <p>&copy; 2025 FitFlow</p>
  </footer>
</body>
</html>
