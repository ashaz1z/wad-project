<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit();
}

include 'wellness_actions.php';

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$wellnessItems = getAllWellnessItems();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Wellness Items | FitFlow</title>
  <link rel="stylesheet" href="assets/css/main.css?v=<?php echo time(); ?>_2">
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
        <li><a href="member_wellness.php" class="active">Wellness Shop</a></li>
        <li><a href="member_history.php">Order History</a></li>
      </ul>
    </aside>

    <main class="dashboard-main">
      <h2>Wellness Shop</h2>
      <p>Invest in your health with our curated selection of wellness items.</p>

      <section class="dashboard-section">
        <?php if (empty($wellnessItems)): ?>
            <div class="empty-state">
                <p>No wellness items available at the moment. Please check back later!</p>
            </div>
        <?php else: ?>
        <div class="items-grid">
            <?php foreach ($wellnessItems as $item): ?>
            <div class="card">
                <h4><?php echo $item['name']; ?></h4>
                <p><?php echo $item['description']; ?></p>
                <p>Price: $<?php echo number_format($item['price'], 2); ?></p>
                
                <?php 
                $stockClass = $item['stock'] > 5 ? 'in-stock' : ($item['stock'] > 0 ? 'low-stock' : 'out-of-stock');
                $stockText = $item['stock'] > 0 ? $item['stock'] . ' in stock' : 'Out of Stock';
                ?>
                <span class="stock-badge <?php echo $stockClass; ?>"><?php echo $stockText; ?></span>

                <?php if ($item['stock'] > 0): ?>
                <form action="purchase.php" method="post">
                    <input type="hidden" name="item_id" value="<?php echo $item['id']; ?>">
                    <input type="hidden" name="price" value="<?php echo $item['price']; ?>">
                    <label for="quantity-<?php echo $item['id']; ?>">Quantity:</label>
                    <input type="number" id="quantity-<?php echo $item['id']; ?>" name="quantity" value="1" min="1" max="<?php echo $item['stock']; ?>">
                    <button type="submit">Purchase</button>
                </form>
                <?php else: ?>
                    <button disabled style="background-color: #ccc; cursor: not-allowed;">Unavailable</button>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
      </section>
    </main>
  </div>
  <script src="assets/js/main.js"></script>
</body>
</html>