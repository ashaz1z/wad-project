<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Member Dashboard | FitFlow</title>
  <link rel="stylesheet" href="assets/css/main.css?v=1.4">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        <li><a href="dashboard.php" class="active">Track Progress</a></li>
        <li><a href="member_workouts.php">Workouts</a></li>
        <li><a href="member_nutrition.php">Nutrition</a></li>
        <li><a href="member_community.php">Community</a></li>
        <li><a href="member_wellness.php">Wellness Shop</a></li>
        <li><a href="member_history.php">Order History</a></li>
      </ul>
    </aside>

    <main class="dashboard-main">
      <h2>Your Progress</h2>
      <p>Welcome back, <?php echo htmlspecialchars($username); ?>! Here is your wellness summary.</p>

      <div class="analytics-grid">
        <div class="card" style="text-align: center;">
            <h4 style="font-size: 2rem; margin-bottom: 0.5rem; color: var(--primary-color);"><?php echo $transactionCount; ?></h4>
            <p>Total Purchases</p>
        </div>
        <div class="card" style="text-align: center;">
            <h4 style="font-size: 2rem; margin-bottom: 0.5rem; color: var(--primary-color);">$<?php echo number_format($totalSpent, 2); ?></h4>
            <p>Total Invested in Wellness</p>
        </div>
      </div>

      <section class="dashboard-section">
        <h3>Fitness Progress (Weight Loss)</h3>
        <div class="card" style="margin-bottom: 2rem;">
            <canvas id="progressChart"></canvas>
        </div>
      </section>

      <section class="dashboard-section">
        <h3>Spending Trends (Last 30 Days)</h3>
        <div class="card">
            <canvas id="spendingChart"></canvas>
        </div>
      </section>
    </main>
  </div>

  <footer>
    <p>&copy; 2025 FitFlow</p>
  </footer>
  <script src="assets/js/main.js"></script>
  <script>
    initDashboardCharts(
        <?php echo json_encode($chartLabels); ?>,
        <?php echo json_encode($chartValues); ?>,
        <?php echo json_encode($progressLabels); ?>,
        <?php echo json_encode($progressValues); ?>
    );
  </script>
</body>
</html>