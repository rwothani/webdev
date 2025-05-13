<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SESSION['role'] === 'admin' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_book'])) {
        $title = $_POST['title'];
        $author = $_POST['author'];
        $isbn = $_POST['isbn'];
        $quantity = $_POST['quantity'];
        $stmt = $pdo->prepare('INSERT INTO books (title, author, isbn, quantity) VALUES (?, ?, ?, ?)');
        $stmt->execute([$title, $author, $isbn, $quantity]);
    } elseif (isset($_POST['delete_book'])) {
        $book_id = $_POST['book_id'];
        $stmt = $pdo->prepare('DELETE FROM books WHERE id = ?');
        $stmt->execute([$book_id]);
    }
}

if ($_SESSION['role'] === 'user' && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['borrow'])) {
    $book_id = $_POST['book_id'];
    $user_id = $_SESSION['user_id'];
    $stmt = $pdo->prepare('SELECT quantity FROM books WHERE id = ?');
    $stmt->execute([$book_id]);
    $book = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($book['quantity'] > 0) {
        $stmt = $pdo->prepare('INSERT INTO borrows (user_id, book_id, borrow_date) VALUES (?, ?, CURDATE())');
        $stmt->execute([$user_id, $book_id]);
        $stmt = $pdo->prepare('UPDATE books SET quantity = quantity - 1 WHERE id = ?');
        $stmt->execute([$book_id]);
    }
}

if ($_SESSION['role'] === 'user' && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['return'])) {
    $borrow_id = $_POST['borrow_id'];
    $book_id = $_POST['book_id'];
    $stmt = $pdo->prepare('UPDATE borrows SET return_date = CURDATE() WHERE id = ?');
    $stmt->execute([$borrow_id]);
    $stmt = $pdo->prepare('UPDATE books SET quantity = quantity + 1 WHERE id = ?');
    $stmt->execute([$book_id]);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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
                
                    <a href="logout.php" class="hover:underline p-2">Logout</a>
                    <a href="index.php" class="hover:underline p-2">Home</a>
                
            </div>
        </div>
    </nav>

    <div class="container mx-auto mt-8">
        <?php if ($_SESSION['role'] === 'admin'): ?>
            <h2 class="text-3xl font-bold mb-4">Manage Books</h2>
            <form method="POST" class="mb-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <input type="text" name="title" placeholder="Title" class="p-2 border rounded" required>
                    <input type="text" name="author" placeholder="Author" class="p-2 border rounded" required>
                    <input type="text" name="isbn" placeholder="ISBN" class="p-2 border rounded" required>
                    <input type="number" name="quantity" placeholder="Quantity" class="p-2 border rounded" required>
                </div>
                <button type="submit" name="add_book" class="bg-blue-600 text-white p-2 rounded mt-4">Add Book</button>
            </form>

            <h3 class="text-2xl font-bold mb-4">Book List</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                <?php
                $stmt = $pdo->query('SELECT * FROM books');
                $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($books as $book):
                ?>
                    <div class="bg-white p-4 rounded shadow">
                        <h4 class="text-xl font-bold"><?php echo htmlspecialchars($book['title']); ?></h4>
                        <p>Author: <?php echo htmlspecialchars($book['author']); ?></p>
                        <p>ISBN: <?php echo htmlspecialchars($book['isbn']); ?></p>
                        <p>Quantity: <?php echo $book['quantity']; ?></p>
                        <form method="POST">
                            <input type="hidden" name="book_id" value="<?php echo $book['id']; ?>">
                            <button type="submit" name="delete_book" class="bg-red-600 text-white p-2 rounded mt-2">Delete</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>

            <h3 class="text-2xl font-bold mb-4">Borrowing Records</h3>
            <div class="bg-white p-6 rounded shadow">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="p-3">User Name</th>
                            <th class="p-3">Book Title</th>
                            <th class="p-3">Borrow Date</th>
                            <th class="p-3">Return Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stmt = $pdo->query('
                            SELECT u.name, b.title, br.borrow_date, br.return_date
                            FROM borrows br
                            JOIN users u ON br.user_id = u.id
                            JOIN books b ON br.book_id = b.id
                            ORDER BY br.borrow_date DESC
                        ');
                        $borrows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($borrows as $borrow):
                        ?>
                            <tr class="border-b">
                                <td class="p-3"><?php echo htmlspecialchars($borrow['name']); ?></td>
                                <td class="p-3"><?php echo htmlspecialchars($borrow['title']); ?></td>
                                <td class="p-3"><?php echo htmlspecialchars($borrow['borrow_date']); ?></td>
                                <td class="p-3"><?php echo $borrow['return_date'] ? htmlspecialchars($borrow['return_date']) : 'Not Returned'; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        <?php else: ?>
            <h2 class="text-3xl font-bold mb-4">My Borrowed Books</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <?php
                $stmt = $pdo->prepare('SELECT b.*, bo.title FROM borrows b JOIN books bo ON b.book_id = bo.id WHERE b.user_id = ? AND b.return_date IS NULL');
                $stmt->execute([$_SESSION['user_id']]);
                $borrows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($borrows as $borrow):
                ?>
                    <div class="bg-white p-4 rounded shadow">
                        <h4 class="text-xl font-bold"><?php echo htmlspecialchars($borrow['title']); ?></h4>
                        <p>Borrowed on: <?php echo $borrow['borrow_date']; ?></p>
                        <form method="POST">
                            <input type="hidden" name="borrow_id" value="<?php echo $borrow['id']; ?>">
                            <input type="hidden" name="book_id" value="<?php echo $borrow['book_id']; ?>">
                            <button type="submit" name="return" class="bg-green-600 text-white p-2 rounded mt-2">Return</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
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