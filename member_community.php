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
  <title>Community | FitFlow</title>
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
        <li><a href="member_community.php" class="active">Community</a></li>
        <li><a href="member_wellness.php">Wellness Shop</a></li>
        <li><a href="member_history.php">Order History</a></li>
      </ul>
    </aside>

    <main class="dashboard-main">
      <h2>Community Feed</h2>
      <p>Connect with other FitFlow members.</p>

      <div class="card" style="margin-bottom: 1rem;">
        <h4>John Doe completed a workout!</h4>
        <p>Just finished a 5k run in 25 minutes. Feeling great! 🏃‍♂️</p>
      </div>
      <div class="card">
        <h4>Sarah Smith shared a recipe</h4>
        <p>Tried this amazing high-protein smoothie bowl today. 🍓🍌</p>
      </div>
    </main>
  </div>
  <script src="assets/js/main.js"></script>
</body>
</html>