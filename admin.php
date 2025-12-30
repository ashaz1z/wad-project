<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.html');
    exit();
}

include 'user_actions.php';
include 'wellness_actions.php';
include 'transaction_actions.php';
include 'dashboard_data.php';

$totalUsers = getTotalUsers();
$totalWellnessItems = getTotalWellnessItems();
$totalTransactions = getTotalTransactions();
$totalRevenue = getTotalRevenue();
$recentTransactions = getRecentTransactions();
$allUsers = getAllUsers();
$allWellnessItems = getAllWellnessItems();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard | FitFlow</title>
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
      <h3>Admin Panel</h3>
      <ul>
        <li><a href="#analytics">Analytics</a></li>
        <li><a href="#manage-users">Manage Users</a></li>
        <li><a href="#manage-wellness-items">Manage Wellness Items</a></li>
        <li><a href="#manage-transactions">Recent Transactions</a></li>
      </ul>
    </aside>

    <main class="dashboard-main">
      <h2>Admin Dashboard</h2>
      <p>Welcome, Admin! Manage the FitFlow platform from here.</p>

      <section id="analytics" class="dashboard-section">
        <h3>Analytics</h3>
        <div class="analytics-grid">
            <div class="card">Total Users: <?php echo $totalUsers; ?></div>
            <div class="card">Total Wellness Items: <?php echo $totalWellnessItems; ?></div>
            <div class="card">Total Transactions: <?php echo $totalTransactions; ?></div>
            <div class="card">Total Revenue: $<?php echo number_format($totalRevenue, 2); ?></div>
        </div>
      </section>

      <section id="manage-users" class="dashboard-section">
        <h3>Manage Users</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($allUsers as $user): ?>
                <tr>
                    <td><?php echo $user['id']; ?></td>
                    <td><?php echo $user['username']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                    <td><a href="edit_user.php?id=<?php echo $user['id']; ?>">Edit</a> | <a href="delete_user.php?id=<?php echo $user['id']; ?>">Delete</a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
      </section>

      <section id="manage-wellness-items" class="dashboard-section">
        <h3>Manage Wellness Items</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($allWellnessItems as $item): ?>
                <tr>
                    <td><?php echo $item['id']; ?></td>
                    <td><?php echo $item['name']; ?></td>
                    <td>$<?php echo number_format($item['price'], 2); ?></td>
                    <td><a href="edit_item.php?id=<?php echo $item['id']; ?>">Edit</a> | <a href="delete_item.php?id=<?php echo $item['id']; ?>">Delete</a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
      </section>

      <section id="manage-transactions" class="dashboard-section">
        <h3>Recent Transactions</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recentTransactions as $transaction): ?>
                <tr>
                    <td><?php echo $transaction['id']; ?></td>
                    <td><?php echo $transaction['username']; ?></td>
                    <td><?php echo $transaction['item_name']; ?></td>
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
