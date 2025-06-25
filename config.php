<?php
// config.php: Database configuration for Laragon MySQL
require_once 'config/database.php';

// Initialize database connection
try {
    $database = new Database();
    $pdo = $database->getConnection();
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}
