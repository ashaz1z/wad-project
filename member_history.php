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
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Transaction History | FitFlow</title>
  <link rel="stylesheet" href="assets/css/main.css?v=<?php echo time(); ?>">
</head>
<body>
  <header>
    <div class="header-brand">
        <a href="index.html"><img src="assets/img/FitFlowLogo.jpeg" alt="Logo" class="logo"></a>
        <h1>FitFlow</h1>
    </div>
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
        <li><a href="dashboard.php">Track Progress</a></li>
        <li><a href="member_workouts.php">Workouts</a></li>
        <li><a href="member_nutrition.php">Nutrition</a></li>
        <li><a href="member_community.php">Community</a></li>
        <li><a href="member_wellness.php">Wellness Shop</a></li>
        <li><a href="member_history.php" class="active">Order History</a></li>
      </ul>
    </aside>

    <main class="dashboard-main">
      <h2>Transaction History</h2>
      <p>View your past purchases and track your wellness investments.</p>

      <section class="dashboard-section">
        <table class="table">
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
</body>
</html>