<?php
require_once 'config.php';

session_start();

// Clear any existing session to avoid conflicts
if (isset($_SESSION['admin_id'])) {
    unset($_SESSION['admin_id']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $password = $_POST['password'];

    try {
        $stmt = $pdo->prepare("SELECT id, password FROM admins WHERE username = ?");
        $stmt->execute([$username]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin && password_verify($password, $admin['password'])) {
            $_SESSION['admin_id'] = $admin['id'];
            header('Location: menu-manage.php');
            exit;
        } else {
            $error = "Invalid username or password";
        }
    } catch (PDOException $e) {
        $error = "Database error: " . htmlspecialchars($e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Palace Restaurant</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=stylesheet">
    <link href="/css/output.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-poppins bg-white text-black flex items-center justify-center min-h-screen">
    <div class="max-w-md w-full bg-yellow-50 p-8 rounded-md shadow-md">
        <h1 class="text-2xl font-bold mb-6 text-center">Admin Login</h1>
        <?php if (isset($error)): ?>
            <p class="text-red-500 mb-4"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1" for="username">Username</label>
                <input type="text" id="username" name="username" class="w-full border rounded-md p-2" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1" for="password">Password</label>
                <input type="password" id="password" name="password" class="w-full border rounded-md p-2" required>
            </div>
            <button type="submit" class="bg-yellow-400 text-black px-6 py-3 rounded-md hover:bg-yellow-500 w-full">Login</button>
        </form>
    </div>
</body>
</html>