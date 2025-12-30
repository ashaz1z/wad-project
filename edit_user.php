<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.html');
    exit();
}

include 'user_actions.php';

if (!isset($_GET['id'])) {
    header('Location: admin.php');
    exit();
}

$user_id = $_GET['id'];
$user = getUserById($user_id);

if (!$user) {
    echo "User not found.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    updateUser($user_id, $username, $email);
    header('Location: admin.php#manage-users');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit User | FitFlow</title>
  <link rel="stylesheet" href="assets/css/main.css">
</head>
<body>
  <header>
    <div class="header-brand">
      <a href="index.html"><img src="assets/img/FitFlowLogo.jpeg" alt="Logo" class="logo"></a>
      <h1>FitFlow</h1>
    </div>
    <nav>
      <a href="admin.php">Admin Dashboard</a>
      <a href="logout.php">Logout</a>
    </nav>
  </header>

  <main class="login-page">
    <div class="login-container">
      <h2>Edit User</h2>
      <form action="edit_user.php?id=<?php echo $user_id; ?>" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        
        <button type="submit">Update User</button>
      </form>
    </div>
  </main>

  <footer>
    <p>&copy; 2025 FitFlow</p>
  </footer>
</body>
</html>