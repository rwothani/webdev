<?php
session_start();
require_once 'config.php';

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $error = 'Please fill in all fields.';
    } else {
        try {
            $stmt = $pdo->prepare("SELECT user_id, username, password, role FROM users WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                header("Location: dashboard.php");
                exit;
            } else {
                $error = 'Invalid username or password.';
            }
        } catch (PDOException $e) {
            $error = 'An error occurred. Please try again.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Electronics Laboratory</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-blue-600 p-4 text-white">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold">Electronics Lab</h1>
            <div>
                <a href="index.php" class="mr-4">Home</a>
                <a href="register.php">Register</a>
            </div>
        </div>
    </nav>

    <!-- Login Form -->
    <section class="py-20">
        <div class="container mx-auto max-w-md">
            <div class="bg-white p-8 rounded-lg shadow-md">
                <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>
                <?php if ($error): ?>
                    <p class="text-red-500 text-center mb-4"><?php echo htmlspecialchars($error); ?></p>
                <?php endif; ?>
                <form method="POST" action="">
                    <div class="mb-4">
                        <label for="username" class="block text-gray-700">Username</label>
                        <input type="text" id="username" name="username" class="w-full p-2 border rounded-lg" required>
                    </div>
                    <div class="mb-6">
                        <label for="password" class="block text-gray-700">Password</label>
                        <input type="password" id="password" name="password" class="w-full p-2 border rounded-lg" required>
                    </div>
                    <button type="submit" class="w-full bg-blue-600 text-white p-2 rounded-lg hover:bg-blue-700">Login</button>
                </form>
                <p class="text-center mt-4">Don't have an account? <a href="register.php" class="text-blue-600">Register</a></p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6">
        <div class="container mx-auto text-center">
            <p>© 2025 Electronics Laboratory. All rights reserved.</p>
            <a href="about.php" class="text-blue-300">About Us</a>
        </div>
    </footer>
</body>
</html>