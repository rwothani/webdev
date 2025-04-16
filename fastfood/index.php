<?php
require_once('database.php');

// Fetch 3 latest menu items for featured section
$stmt = $pdo->query("SELECT * FROM menu ORDER BY id DESC LIMIT 3");
$featured = $stmt->fetchAll();
?>
<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Fast Bites | Home</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
    /* Custom fonts or overrides here */
    body {
        font-family: 'Segoe UI', sans-serif;
    }
    </style>
</head>

<body class="bg-white text-black">

    <!-- Navbar -->
    <nav class="bg-orange-500 text-white p-12 shadow-md flex justify-between items-center">
        <h1 class="text-2xl font-bold">🍔 Fast Bites</h1>
        <ul class="flex space-x-6 font-medium">
            <li><a href="index.php" class="hover:text-black">Home</a></li>
            <li><a href="menu.php" class="hover:text-black">Menu</a></li>
            <li><a href="cart.php" class="hover:text-black">Cart</a></li>
            <li><a href="contact.php" class="hover:text-black">Contact</a></li>
            <?php if (isset($_SESSION['user_id'])): ?>
            <a href="logout.php" class="hover:text-black">Logout</a>
            <?php else: ?>
            <a href="login.php" class="hover:text-black">Login</a>
            <?php endif; ?>

            <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
            <a href="admin.php" class="hover:text-black">Admin Panel</a>
            <?php endif; ?>

        </ul>
    </nav>

    <!-- Hero Section -->
    <section class="relative bg-cover bg-center h-[85vh]" style="background-image: url('images/hero-burger.jpg');">
        <div
            class="bg-black bg-opacity-60 h-full w-full flex flex-col justify-center items-center text-center text-white p-4">
            <h2 class="text-4xl md:text-6xl font-bold mb-4">Satisfy Your Cravings</h2>
            <p class="text-xl md:text-2xl mb-6">Delicious fast food delivered hot and fresh</p>
            <a href="menu.php"
                class="bg-orange-400 text-white px-6 py-3 rounded-xl text-lg hover:bg-orange-600 transition-all">Order
                Now</a>
        </div>
    </section>

    <!-- Featured Menu -->


    <section class="py-12 px-4 md:px-20 bg-amber-50">
        <h3 class="text-3xl font-bold text-center text-amber-900 mb-10">🔥 Featured Items</h3>
        <div class="grid md:grid-cols-3 gap-8">

            <?php foreach ($featured as $item): ?>
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
                <img src="images/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>"
                    class="w-full h-56 object-cover">
                <div class="p-4">
                    <h4 class="text-xl font-bold text-orange-500"><?= htmlspecialchars($item['name']) ?></h4>
                    <p class="text-gray-700 mb-2"><?= htmlspecialchars($item['description']) ?></p>
                    <span class="text-brown-700 font-semibold">$<?= number_format($item['price'], 2) ?></span>
                </div>
            </div>
            <?php endforeach; ?>

        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-black text-white text-center p-6 mt-10">
        <p>&copy; 2025 Fast Bites. All rights reserved.</p>
        <p>Contact us: info@fastbites.com</p>
    </footer>

</body>

</html>