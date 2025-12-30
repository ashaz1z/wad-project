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
  <title>Workouts | FitFlow</title>
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
        <li><a href="member_workouts.php" class="active">Workouts</a></li>
        <li><a href="member_nutrition.php">Nutrition</a></li>
        <li><a href="member_community.php">Community</a></li>
        <li><a href="member_wellness.php">Wellness Shop</a></li>
        <li><a href="member_history.php">Order History</a></li>
      </ul>
    </aside>

    <main class="dashboard-main">
      <h2>Choose Your Workout</h2>
      <p>Select a category to start your training session.</p>

      <div class="items-grid">
        <div class="card" style="text-align: center;">
            <div style="font-size: 3rem; margin-bottom: 1rem;">🏃</div>
            <h4>Cardio</h4>
            <p>Boost your endurance with running, cycling, and HIIT.</p>
            <button class="btn">Start Cardio</button>
        </div>
        <div class="card" style="text-align: center;">
            <div style="font-size: 3rem; margin-bottom: 1rem;">🏋️</div>
            <h4>Weightlifting</h4>
            <p>Build strength and muscle with compound lifts.</p>
            <button class="btn">Start Lifting</button>
        </div>
        <div class="card" style="text-align: center;">
            <div style="font-size: 3rem; margin-bottom: 1rem;">🧘</div>
            <h4>Yoga & Mobility</h4>
            <p>Improve flexibility and recovery.</p>
            <button class="btn">Start Yoga</button>
        </div>
      </div>
    </main>
  </div>
  <script src="assets/js/main.js"></script>
</body>
</html>