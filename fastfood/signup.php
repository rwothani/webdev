<?php
session_start();
require_once('database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);

    if ($stmt->fetch()) {
        $error = "Email already registered.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $password]);
        $_SESSION['user_id'] = $pdo->lastInsertId();
        $_SESSION['user_name'] = $name;
        header("Location: index.php");
        exit();
    }
}
?>

<!-- HTML Form -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sign Up</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-amber-50 flex justify-center items-center h-screen">
  <form method="POST" class="bg-white p-10 rounded-2xl shadow-xl w-96 space-y-4">
    <h2 class="text-2xl font-bold text-orange-600 text-center">Create Account</h2>
    <?php if (!empty($error)): ?>
      <p class="text-red-500 text-sm text-center"><?= $error ?></p>
    <?php endif; ?>
    <input name="name" type="text" required placeholder="Full Name" class="w-full border p-2 rounded">
    <input name="email" type="email" required placeholder="Email" class="w-full border p-2 rounded">
    <input name="password" type="password" required placeholder="Password" class="w-full border p-2 rounded">
    <button type="submit" class="bg-orange-500 text-white w-full py-2 rounded hover:bg-orange-600">Sign Up</button>
    <p class="text-sm text-center">Already have an account? <a href="login.php" class="text-blue-600 underline">Log in</a></p>
  </form>
</body>
</html>
