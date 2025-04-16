<?php require 'backend/database.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Simple Blog</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

    <nav class="bg-white shadow p-4 flex justify-between">
        <h1 class="text-xl font-bold text-indigo-600">My Blog</h1>
        <div class="space-x-4">
            <a href="index.php" class="text-indigo-600 hover:underline">Home</a>
            <a href="about.php" class="text-indigo-600 hover:underline">About</a>
            <a href="contact.php" class="text-indigo-600 hover:underline">Contact</a>
            <a href="add.php" class="text-white bg-indigo-600 px-3 py-1 rounded hover:bg-indigo-700">+ New Post</a>
        </div>
    </nav>

    <main class="max-w-3xl mx-auto mt-8">
        <h2 class="text-2xl font-bold mb-4">Recent Posts</h2>

        <?php
        $stmt = $pdo->query("SELECT * FROM posts ORDER BY created_at DESC");
        while ($post = $stmt->fetch()):
        ?>
            <div class="bg-white p-4 rounded shadow mb-4">
                <h3 class="text-xl font-semibold text-indigo-700">
                    <a href="post.php?id=<?= $post['id']; ?>" class="hover:underline">
                        <?= htmlspecialchars($post['title']); ?>
                    </a>
                </h3>
                <p class="text-gray-600 text-sm mb-2"><?= date('F j, Y', strtotime($post['created_at'])); ?></p>
                <p><?= nl2br(substr(htmlspecialchars($post['content']), 0, 100)); ?>...</p>
                <a href="post.php?id=<?= $post['id']; ?>" class="text-indigo-600 hover:underline mt-2 inline-block">Read more</a>
            </div>
        <?php endwhile; ?>
    </main>

</body>
</html>
