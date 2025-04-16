<?php
require_once('database.php');
$stmt = $pdo->query("SELECT * FROM menu ORDER BY id DESC");
$menu = $stmt->fetchAll();
?>
<?php
session_start();
?>
<!-- menu.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu | FastFood</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-white text-gray-900">
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
        </ul>
    </nav>

    <section class="px-6 md:px-20 py-12 bg-amber-50">
        <h2 class="text-4xl font-bold text-center text-orange-600 mb-10">🍽 Our Menu</h2>
        <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-10">

            <?php foreach ($menu as $item): ?>
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition duration-300">
                <img src="images/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>"
                    class="w-full h-56 object-cover">

                <div class="p-5">
                    <h3 class="text-xl font-semibold text-orange-500"><?= htmlspecialchars($item['name']) ?></h3>
                    <p class="text-sm text-gray-600 mb-3"><?= htmlspecialchars($item['description']) ?></p>

                    <form action="add_to_cart.php" method="POST" class="flex justify-between items-center gap-2">
                        <input type="hidden" name="menu_id" value="<?= $item['id'] ?>">
                        <input type="hidden" name="name" value="<?= $item['name'] ?>">
                        <input type="hidden" name="price" value="<?= $item['price'] ?>">

                        <span class="text-brown-700 font-bold">$<?= number_format($item['price'], 2) ?></span>

                        <input type="number" name="quantity" value="1" min="1"
                            class="border border-gray-300 px-2 py-1 w-16 rounded text-sm">

                        <button type="submit"
                            class="bg-orange-500 text-white px-4 py-1 rounded hover:bg-orange-600 transition">Add to
                            Cart</button>
                    </form>
                </div>
            </div>
            <?php endforeach; ?>


        </div>
    </section>

</body>

</html>