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

$template = file_get_contents('edit_user.html');
$template = str_replace('{{id}}', $user['id'], $template);
$template = str_replace('{{username}}', htmlspecialchars($user['username']), $template);
$template = str_replace('{{email}}', htmlspecialchars($user['email']), $template);
echo $template;
?>