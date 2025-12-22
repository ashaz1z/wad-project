<?php
session_start();

// Include database connection
require_once 'config/db_connect.php';

// Initialize variables
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'register') {
        // Registration logic
        $username = trim($_POST['username']);
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $role = $_POST['role'];

        // Validation
        if ($password !== $confirm_password) {
            $error = 'password_mismatch';
        } else {
            // Check if username exists
            $users_file = 'users.json';
            $users = file_exists($users_file) ? json_decode(file_get_contents($users_file), true) : [];

            if (isset($users[$username])) {
                $error = 'username_exists';
            } else {
                // Save user (plain text for demo)
                $users[$username] = [
                    'password' => $password,
                    'role' => $role,
                    'created_at' => date('Y-m-d H:i:s')
                ];

                file_put_contents($users_file, json_encode($users, JSON_PRETTY_PRINT));

                // Auto-login after registration
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $role;

                // Redirect to appropriate dashboard
                if ($role === 'admin') {
                    header('Location: admin.html');
                } else {
                    header('Location: dashboard.html');
                }
                exit;
            }
        }
    } else {
        // Login logic
        $username = trim($_POST['username']);
        $password = $_POST['password'];
        $role = $_POST['role'];

        // Load users
        $users_file = 'users.json';
        $users = file_exists($users_file) ? json_decode(file_get_contents($users_file), true) : [];

        // Check credentials
        if (isset($users[$username]) && $users[$username]['password'] === $password && $users[$username]['role'] === $role) {
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;

            // Redirect to appropriate dashboard
            if ($role === 'admin') {
                header('Location: admin.html');
            } else {
                header('Location: dashboard.html');
            }
            exit;
        } else {
            $error = 'invalid_credentials';
        }
    }
}

// Redirect back to login with error
if ($error) {
    header('Location: login.html?error=' . $error);
    exit;
}
?>
