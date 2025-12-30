<?php
include 'config/db_connect.php';

// Create User
function createUser($username, $password, $email) {
    global $conn;
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $hashed_password, $email);
    return $stmt->execute();
}

// Get User by ID
function getUserById($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT id, username, email, created_at FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// Get User by Username
function getUserByUsername($username) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// Get all users
function getAllUsers() {
    global $conn;
    $result = $conn->query("SELECT id, username, email, created_at FROM users");
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Update User
function updateUser($id, $username, $email) {
    global $conn;
    $stmt = $conn->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
    $stmt->bind_param("ssi", $username, $email, $id);
    return $stmt->execute();
}

// Delete User
function deleteUser($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}
?>
