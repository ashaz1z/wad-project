<?php
session_start();
include 'user_actions.php';

// Registration
if (isset($_POST['action']) && $_POST['action'] == 'register') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $email = $_POST['username'] . '@example.com'; // Using username as a dummy email

    if ($password !== $confirm_password) {
        header('Location: login.html?error=password_mismatch#register');
        exit();
    }

    if (getUserByUsername($username)) {
        header('Location: login.html?error=username_exists#register');
        exit();
    }

    if (createUser($username, $password, $email)) {
        header('Location: login.html');
        exit();
    } else {
        header('Location: login.html?error=registration_failed#register');
        exit();
    }
}

// Login
$username = $_POST['username'];
$password = $_POST['password'];
$role = $_POST['role'];

$user = getUserByUsername($username);

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $role;

    if ($role === 'admin') {
        header('Location: admin.html');
    } else {
        header('Location: dashboard.html');
    }
    exit();
} else {
    header('Location: login.html?error=invalid_credentials');
    exit();
}
?>
