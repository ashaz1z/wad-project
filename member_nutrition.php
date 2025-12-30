<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Nutrition | FitFlow</title>
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
        <li><a href="member_nutrition.php" class="active">Nutrition</a></li>
        <li><a href="member_community.php">Community</a></li>
        <li><a href="member_wellness.php">Wellness Shop</a></li>
        <li><a href="member_history.php">Order History</a></li>
      </ul>
    </aside>

    <main class="dashboard-main">
      <h2>Nutrition Plans</h2>
      <p>Fuel your body with the right nutrients.</p>

      <div class="card">
        <h3>Daily Calorie Goal</h3>
        <p>Your target: <strong>2,200 kcal</strong></p>
        <div style="background: #eee; height: 20px; border-radius: 10px; overflow: hidden;">
            <div style="background: var(--primary-color); width: 65%; height: 100%;"></div>
        </div>
        <p style="margin-top: 0.5rem; font-size: 0.9rem;">1,430 kcal consumed today</p>
      </div>
    </main>
  </div>
  <script src="assets/js/main.js"></script>
</body>
</html>