<?php
require_once 'config.php';
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    if ($action === 'add') {
        $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
        $price = floatval($_POST['price']);
        $category = $_POST['category'];
        $date = $_POST['date'] ?: null;
        $image = $_FILES['image']['name'] ? 'assets/images/' . basename($_FILES['image']['name']) : '';

        if ($image) {
            move_uploaded_file($_FILES['image']['tmp_name'], '../' . $image);
        }

        $stmt = $pdo->prepare("INSERT INTO menu_items (name, description, price, category, date, image) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $description, $price, $category, $date, $image]);
    } elseif ($action === 'delete') {
        $id = intval($_POST['id']);
        $stmt = $pdo->prepare("DELETE FROM menu_items WHERE id = ?");
        $stmt->execute([$id]);
    }
}

// Fetch menu items
$stmt = $pdo->query("SELECT * FROM menu_items ORDER BY date DESC, category, name");
$menu_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Menu - Palace Restaurant</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="/css/output.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="font-poppins bg-white text-black">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-3xl font-bold mb-8">Manage Menu</h1>
        
        <!-- Add Menu Item Form -->
        <form method="POST" enctype="multipart/form-data" class="mb-12 bg-yellow-50 p-6 rounded-md">
            <input type="hidden" name="action" value="add">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1" for="name">Dish Name</label>
                    <input type="text" id="name" name="name" class="w-full border rounded-md p-2" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1" for="price">Price</label>
                    <input type="number" id="price" name="price" step="0.01" class="w-full border rounded-md p-2" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1" for="category">Category</label>
                    <select id="category" name="category" class="w-full border rounded-md p-2" required>
                        <option value="local">Local</option>
                        <option value="foreign">Foreign</option>
                        <option value="special">Daily Special</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1" for="date">Special Date (Optional)</label>
                    <input type="date" id="date" name="date" class="w-full border rounded-md p-2">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium mb-1" for="description">Description</label>
                    <textarea id="description" name="description" class="w-full border rounded-md p-2" rows="4"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1" for="image">Image</label>
                    <input type="file" id="image" name="image" accept="image/jpeg,image/png" class="w-full border rounded-md p-2">
                </div>
            </div>
            <button type="submit" class="mt-4 bg-yellow-400 text-black px-6 py-3 rounded-md hover:bg-yellow-500">Add Dish</button>
        </form>

        <!-- Menu Items List -->
        <h2 class="text-2xl font-semibold mb-4">Current Menu</h2>
       <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php foreach ($menu_items as $item): ?>
        <div class="bg-white shadow-md rounded-md overflow-hidden">
            <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" class="w-full h-48 object-cover">
            <div class="p-4">
                <h3 class="text-xl font-semibold"><?php echo htmlspecialchars($item['name']); ?></h3>
                <p class="text-gray-600 mt-2"><?php echo htmlspecialchars($item['description']); ?></p>
                <p class="text-yellow-400 font-bold mt-2">$<?php echo number_format($item['price'], 2); ?></p>
                <p class="text-sm text-gray-500 mt-1">Category: <?php echo ucfirst($item['category']); ?></p>
                <?php if ($item['date']): ?>
                    <p class="text-sm text-gray-500">Special: <?php echo date('Y-m-d', strtotime($item['date'])); ?></p>
                <?php endif; ?>
                <form method="POST" class="mt-4">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Delete</button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
</div>
    </div>
</body>
</html>