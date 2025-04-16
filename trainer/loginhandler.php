<?php
session_start();
require_once 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        die("Username and password are required.");
    }

    try {
        // Fetch user by username
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Valid login – set session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['name'] = $user['name'];

            // Redirect to dashboard
            header("Location: dashboard.php");
            exit;
        } else {
            // Invalid login
            echo "Invalid username or password.";
        }
    } catch (PDOException $e) {
        die("Login failed: " . $e->getMessage());
    }
} else {
    die("Invalid request.");
}
?>
