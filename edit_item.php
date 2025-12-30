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

$template = file_get_contents('edit_item.html');
$template = str_replace('{{id}}', $item['id'], $template);
$template = str_replace('{{name}}', htmlspecialchars($item['name']), $template);
$template = str_replace('{{description}}', htmlspecialchars($item['description']), $template);
$template = str_replace('{{price}}', $item['price'], $template);
$template = str_replace('{{stock}}', $item['stock'], $template);
echo $template;
?>
