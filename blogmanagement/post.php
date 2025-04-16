<?php
require 'backend/database.php';

// Get the post ID from the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare the SQL to fetch the post
    $stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
    $stmt->execute([$id]);
    $post = $stmt->fetch();

    // Check if the post exists
    if (!$post) {
        echo "Post not found.";
        exit();
    }
} else {
    echo "Invalid request.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($post['title']); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

    <nav class="bg-white shadow p-4 flex justify-between">
        <h1 class="text-xl font-bold text-indigo-600">My Blog</h1>
        <div class="space-x-4">
            <a href="index.php" class="text-indigo-600 hover:underline">Home</a>
            <a href="about.php" class="text-indigo-600 hover:underline">About</a>
        </div>
    </nav>

    <main class="max-w-3xl mx-auto mt-10 bg-white p-6 rounded shadow">
        <h2 class="text-3xl font-bold text-indigo-700"><?= htmlspecialchars($post['title']); ?></h2>
        <p class="text-gray-600 text-sm mb-4"><?= date('F j, Y', strtotime($post['created_at'])); ?></p>
        <p class="text-gray-800"><?= nl2br(htmlspecialchars($post['content'])); ?></p>
    </main>

</body>
</html>
