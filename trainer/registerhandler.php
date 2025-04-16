<?php
require_once 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Clean and collect form inputs
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $address = trim($_POST['address']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Basic validation
    if (empty($name) || empty($phone) || empty($email) || empty($address) || empty($username) || empty($password)) {
        die("All fields are required.");
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        // Check if username or email already exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
        $stmt->execute([$email, $username]);

        if ($stmt->fetch()) {
            die("Email or username already in use.");
        }

        // Insert new user
        $insert = $pdo->prepare("
            INSERT INTO users (name, phone, email, address, username, password)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $insert->execute([$name, $phone, $email, $address, $username, $hashedPassword]);

       // ✅ Redirect to login.php
       header("Location: login.php");
       exit;

    } catch (PDOException $e) {
        die("Registration failed: " . $e->getMessage());
    }
} else {
    die("Invalid request.");
}
?>
