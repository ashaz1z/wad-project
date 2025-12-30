<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.html');
    exit();
}

include 'wellness_actions.php';

$item_id = $_GET['id'];
$item = getWellnessItemById($item_id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    updateWellnessItem($item_id, $name, $description, $price, $stock);
    header('Location: admin.php#manage-wellness-items');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Wellness Item | FitFlow</title>
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
      <h2>Edit Wellness Item</h2>
      <form action="edit_item.php?id=<?php echo $item_id; ?>" method="post">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $item['name']; ?>" required>
        <label for="description">Description:</label>
        <input type="text" id="description" name="description" value="<?php echo $item['description']; ?>" required>
        <label for="price">Price:</label>
        <input type="number" step="0.01" id="price" name="price" value="<?php echo $item['price']; ?>" required>
        <label for="stock">Stock:</label>
        <input type="number" id="stock" name="stock" value="<?php echo $item['stock']; ?>" required>
        <button type="submit">Update Item</button>
      </form>
    </div>
  </main>

  <footer>
    <p>&copy; 2025 FitFlow</p>
  </footer>
</body>
</html>
