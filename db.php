<?php
$db = new PDO("sqlite:transactions.db");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$db->exec("
CREATE TABLE IF NOT EXISTS transactions (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    items TEXT,
    total REAL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)");
