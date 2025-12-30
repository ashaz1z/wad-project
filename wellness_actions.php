<?php
include 'config/db_connect.php';

// Create Wellness Item
function createWellnessItem($name, $description, $price) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO wellness_items (name, description, price) VALUES (?, ?, ?)");
    $stmt->bind_param("ssd", $name, $description, $price);
    return $stmt->execute();
}

// Get Wellness Item by ID
function getWellnessItemById($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT id, name, description, price, created_at FROM wellness_items WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// Get all Wellness Items
function getAllWellnessItems() {
    global $conn;
    $result = $conn->query("SELECT id, name, description, price, created_at FROM wellness_items");
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Update Wellness Item
function updateWellnessItem($id, $name, $description, $price) {
    global $conn;
    $stmt = $conn->prepare("UPDATE wellness_items SET name = ?, description = ?, price = ? WHERE id = ?");
    $stmt->bind_param("ssdi", $name, $description, $price, $id);
    return $stmt->execute();
}

// Delete Wellness Item
function deleteWellnessItem($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM wellness_items WHERE id = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}
?>
