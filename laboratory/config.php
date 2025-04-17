<?php
// Database configuration
$host = 'localhost';
$dbname = 'electronics_lab';
$username = 'root'; // Replace with your MySQL username
$password = ''; // Replace with your MySQL password

try {
    // Create PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    
    // Set PDO attributes
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    // Log error (in production, log to file instead of displaying)
    die("Connection failed: " . $e->getMessage());
}
?>