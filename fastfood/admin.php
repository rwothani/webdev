<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != true) {
    header("Location: login.php");
    exit();
}
?>

<?php
require_once('database.php');

$stmt = $pdo->query("SELECT * FROM menu ORDER BY id DESC");
$items = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Panel | Fast Bites</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-amber-50 text-black min-h-screen">

    <!-- Header -->
    <header class="bg-orange-500 text-white p-12 shadow-md flex justify-between items-center">
        <h1 class="text-2xl font-bold">🍔 Admin Panel - Fast Bites</h1>
        <a href="index.php" class="bg-black px-4 py-2 rounded-lg hover:bg-gray-800 transition">Go to Website</a>
    </header>

    <main class="p-6 md:p-10">

        <!-- Add New Item -->
        <section class="mb-12">
            <h2 class="text-2xl font-bold mb-4 text-orange-600">➕ Add New Menu Item</h2>
            <form action="add_item.php" class="bg-white shadow-lg rounded-xl p-6 grid md:grid-cols-2 gap-6"
                method="POST" enctype="multipart/form-data">
                <div>
                    <label class="block font-semibold mb-1">Food Name</label>
                    <input type="text" name="name" required class="w-full border border-gray-300 rounded-lg p-2"
                        placeholder="e.g., Classic Burger" />
                </div>

                <div>
                    <label class="block font-semibold mb-1">Category</label>
                    <input type="text" name="category" required class="w-full border border-gray-300 rounded-lg p-2"
                        placeholder="e.g., Burger, Drink" />
                </div>

                <div class="md:col-span-2">
                    <label class="block font-semibold mb-1">Description</label>
                    <textarea name="description" required class="w-full border border-gray-300 rounded-lg p-2 h-24"
                        placeholder="Write something tasty..."></textarea>
                </div>

                <div>
                    <label class="block font-semibold mb-1">Price ($)</label>
                    <input type="number" step="0.01" name="price" placeholder="price"
                        class="w-full border border-gray-300 rounded-lg p-2" />
                </div>

                <div>
                    <label class="block font-semibold mb-1">Image</label>
                    <input type="file" name="image" accept="image/*" placeholder="image"
                        class="w-full border border-gray-300 rounded-lg p-2" />
                </div>

                <div class="md:col-span-2 flex justify-end">
                    <button type="submit"
                        class="bg-orange-500 text-white px-6 py-2 rounded-lg hover:bg-orange-600 transition">Add
                        Item</button>
                </div>
            </form>
        </section>

        <!-- Menu Item Table (Mockup) -->
        <section>
            <h2 class="text-2xl font-bold mb-4 text-orange-600">📋 Existing Menu Items</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white shadow-md rounded-xl overflow-hidden">
                    <thead class="bg-orange-400 text-white">
                        <tr>
                            <th class="text-left p-3">Image</th>
                            <th class="text-left p-3">Name</th>
                            <th class="text-left p-3">Category</th>
                            <th class="text-left p-3">Price</th>
                            <th class="text-left p-3">Actions</th>
                        </tr>
                    </thead>


                    <tbody>

                        <?php if (count($items) > 0): ?>
                        <?php foreach ($items as $item): ?>
                        <tr class="border-t hover:bg-orange-50 transition">
                            <td class="p-3">
                                <img src="images/<?= htmlspecialchars($item['image']) ?>"
                                    class="h-12 w-12 object-cover rounded-lg" alt="">
                            </td>
                            <td class="p-3 font-semibold"><?= htmlspecialchars($item['name']) ?></td>
                            <td class="p-3"><?= htmlspecialchars($item['category']) ?></td>
                            <td class="p-3">$<?= number_format($item['price'], 2) ?></td>
                            <td class="p-3 space-x-2">
                                <form action="php/admin/delete_item.php" method="POST" class="inline">
                                    <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                    <button type="submit"
                                        class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">Delete</button>
                                </form>
                                <!-- Edit button can be enhanced later -->
                                <button class="bg-black text-white px-3 py-1 rounded hover:bg-gray-800">Edit</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center p-4 text-gray-500">No menu items found.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer class="bg-black text-white text-center p-4 mt-12">
        <p>&copy; 2025 Fast Bites | Admin Dashboard</p>
    </footer>

</body>

</html>