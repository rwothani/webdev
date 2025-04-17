<?php
session_start();
require_once 'config.php';

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role = $_POST['role'];

    // Validate input
    if (empty($username) || empty($email) || empty($password) || empty($role)) {
        $error = 'Please fill in all fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email format.';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters.';
    } elseif (!in_array($role, ['student', 'instructor', 'admin'])) {
        $error = 'Invalid role selected.';
    } else {
        try {
            // Check for duplicate username or email
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ? OR email = ?");
            $stmt->execute([$username, $email]);
            if ($stmt->fetchColumn() > 0) {
                $error = 'Username or email already exists.';
            } else {
                // Hash password and insert user
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
                $stmt->execute([$username, $email, $hashed_password, $role]);
                $success = 'Registration successful! Please <a href="login.php" class="text-blue-600">login</a>.';
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
    <title>Register - Electronics Laboratory</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-blue-600 p-4 text-white">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold">Electronics Lab</h1>
            <div>
                <a href="index.php" class="mr-4">Home</a>
                <a href="login.php">Login</a>
            </div>
        </div>
    </nav>

    <!-- Register Form -->
    <section class="py-20">
        <div class="container mx-auto max-w-md">
            <div class="bg-white p-8 rounded-lg shadow-md">
                <h2 class="text-2xl font-bold mb-6 text-center">Register</h2>
                <?php if ($error): ?>
                    <p class="text-red-500 text-center mb-4"><?php echo htmlspecialchars($error); ?></p>
                <?php endif; ?>
                <?php if ($success): ?>
                    <p class="text-green-500 text-center mb-4"><?php echo $success; ?></p>
                <?php endif; ?>
                <form method="POST" action="">
                    <div class="mb-4">
                        <label for="username" class="block text-gray-700">Username</label>
                        <input type="text" id="username" name="username" class="w-full p-2 border rounded-lg" required>
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700">Email</label>
                        <input type="email" id="email" name="email" class="w-full p-2 border rounded-lg" required>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="block text-gray-700">Password</label>
                        <input type="password" id="password" name="password" class="w-full p-2 border rounded-lg" required>
                    </div>
                    <div class="mb-6">
                        <label for="role" class="block text-gray-700">Role</label>
                        <select id="role" name="role" class="w-full p-2 border rounded-lg" required>
                            <option value="student">Student</option>
                            <option value="instructor">Instructor</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full bg-blue-600 text-white p-2 rounded-lg hover:bg-blue-700">Register</button>
                </form>
                <p class="text-center mt-4">Already have an account? <a href="login.php" class="text-blue-600">Login</a></p>
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