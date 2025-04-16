<?php
session_start();
require_once('database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['is_admin'] = $user['is_admin'];
        header("Location: index.php");
        exit();
    } else {
        $error = "Invalid email or password.";
    }
}
?>

<!-- HTML Form -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-amber-50 flex justify-center items-center h-screen">
  <form method="POST" class="bg-white p-10 rounded-2xl shadow-xl w-96 space-y-4">
    <h2 class="text-2xl font-bold text-orange-600 text-center">Login</h2>
    <?php if (!empty($error)): ?>
      <p class="text-red-500 text-sm text-center"><?= $error ?></p>
    <?php endif; ?>
    <input name="email" type="email" required placeholder="Email" class="w-full border p-2 rounded">
    <input name="password" type="password" required placeholder="Password" class="w-full border p-2 rounded">
    <button type="submit" class="bg-black text-white w-full py-2 rounded hover:bg-gray-800">Login</button>
    <p class="text-sm text-center">Don't have an account? <a href="signup.php" class="text-blue-600 underline">Sign up</a></p>
  </form>
</body>
</html>
