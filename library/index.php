<?php
session_start();
require_once 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .nav-bg {
            background-image: url('https://images.unsplash.com/photo-1521587760476-6c12a4b040da?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            position: relative;
        }
        .nav-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5); /* Semi-transparent overlay for readability */
            z-index: 1;
        }
        .nav-content {
            position: relative;
            z-index: 2;
        }
    </style>
</head>
<body class="bg-gray-100">
    <nav class="nav-bg p-12 text-white">
        <div class="container mx-auto flex justify-between nav-content">
            <div>
                <h1 class="text-3xl font-bold">Library Management System</h1>
                <p class="text-lg italic text-gray-200 mt-1">The Library, Where Knowledge Glows Like a Bright Moon</p>
            </div>
            <div class="flex items-center">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="dashboard.php" class="mr-4 hover:underline">Dashboard</a>
                    <?php if ($_SESSION['role'] === 'user'): ?>
                        <a href="dashboard.php" class="mr-4 hover:underline">Borrow</a>
                    <?php endif; ?>
                    <a href="logout.php" class="hover:underline">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="mr-4 hover:underline">Login</a>
                    <a href="register.php" class="hover:underline">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="container mx-auto mt-8">
        <h2 class="text-3xl font-bold mb-4">Available Books</h2>
        <form method="GET" class="mb-4">
            <input type="text" name="search" placeholder="Search by title or author" class="p-2 border rounded">
            <button type="submit" class="bg-gray-800 text-white p-2 rounded">Search</button>
        </form>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <?php
            $search = isset($_GET['search']) ? $_GET['search'] : '';
            $query = "SELECT * FROM books WHERE title LIKE :search OR author LIKE :search";
            $stmt = $pdo->prepare($query);
            $stmt->execute(['search' => "%$search%"]);
            $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($books as $book):
            ?>
                <div class="bg-white p-4 rounded shadow">
                    <h3 class="text-xl font-bold"><?php echo htmlspecialchars($book['title']); ?></h3>
                    <p>Author: <?php echo htmlspecialchars($book['author']); ?></p>
                    <p>ISBN: <?php echo htmlspecialchars($book['isbn']); ?></p>
                    <p>Available: <?php echo $book['quantity']; ?></p>
                    <?php if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'user'): ?>
                        <form method="POST" action="dashboard.php">
                            <input type="hidden" name="book_id" value="<?php echo $book['id']; ?>">
                            <button type="submit" name="borrow" class="bg-green-600 text-white p-2 rounded mt-2" <?php echo $book['quantity'] == 0 ? 'disabled' : ''; ?>>Borrow</button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <footer class="bg-gray-800 text-white py-6">
    <div class="container mx-auto text-center">
        <div class="mb-4">
            <a href="index.php" class="text-xl font-bold hover:text-gray-300">Library Management System</a>
            <p class="text-sm italic text-gray-400 mt-1">Where Knowledge Glows Like a Bright Moon</p>
        </div>
        <div class="flex justify-center space-x-4 mb-4">
            <a href="#" class="hover:text-gray-300">About</a>
            <a href="#" class="hover:text-gray-300">Contact</a>
            <a href="#" class="hover:text-gray-300">Privacy Policy</a>
        </div>
        <p class="text-sm">&copy; 2025 Library Management System. All rights reserved.</p>
    </div>
</footer>
</body>
</html>