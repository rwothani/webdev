<?php
session_start();
require_once 'config.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['borrow'])) {
    $equipment_id = $_POST['equipment_id'];
    try {
        // Check if equipment is available
        $stmt = $pdo->prepare("SELECT status FROM equipment WHERE equipment_id = ?");
        $stmt->execute([$equipment_id]);
        $equipment = $stmt->fetch();

        if ($equipment && $equipment['status'] === 'available') {
            // Update equipment status and borrower
            $stmt = $pdo->prepare("UPDATE equipment SET status = 'borrowed', borrower_id = ?, borrow_date = NOW(), return_date = DATE_ADD(NOW(), INTERVAL 1 DAY) WHERE equipment_id = ?");
            $stmt->execute([$_SESSION['user_id'], $equipment_id]);
            $success = 'Equipment borrowed successfully!';
        } else {
            $error = 'Equipment is not available.';
        }
    } catch (PDOException $e) {
        $error = 'An error occurred. Please try again.';
    }
}

// Handle adding new equipment (admin only)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_equipment']) && $_SESSION['role'] === 'admin') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);

    if (empty($name)) {
        $error = 'Equipment name is required.';
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO equipment (name, description, status) VALUES (?, ?, 'available')");
            $stmt->execute([$name, $description]);
            $success = 'Equipment added successfully!';
        } catch (PDOException $e) {
            $error = 'An error occurred. Please try again.';
        }
    }
}

// Fetch available equipment
$stmt = $pdo->query("SELECT * FROM equipment WHERE status = 'available' ORDER BY name");
$available_equipment = $stmt->fetchAll();

// Fetch user's borrowing history
$stmt = $pdo->prepare("SELECT e.*, u.username FROM equipment e JOIN users u ON e.borrower_id = u.user_id WHERE e.borrower_id = ? AND e.status = 'borrowed' ORDER BY e.borrow_date DESC");
$stmt->execute([$_SESSION['user_id']]);
$borrowing_history = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrow Equipment - Electronics Laboratory</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-blue-600 p-4 text-white">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold">Electronics Lab</h1>
            <div>
                <a href="index.php" class="mr-4">Home</a>
                <a href="dashboard.php" class="mr-4">Dashboard</a>
                <a href="schedule.php" class="mr-4">Schedule Practicals</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Borrow Equipment -->
    <section class="py-10">
        <div class="container mx-auto">
            <h2 class="text-2xl font-bold mb-6 text-center">Borrow Equipment</h2>
            <?php if ($error): ?>
                <p class="text-red-500 text-center mb-4"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
            <?php if ($success): ?>
                <p class="text-green-500 text-center mb-4"><?php echo htmlspecialchars($success); ?></p>
            <?php endif; ?>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold mb-4">Available Equipment</h3>
                <?php if (empty($available_equipment)): ?>
                    <p class="text-center">No equipment available.</p>
                <?php else: ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php foreach ($available_equipment as $item): ?>
                            <div class="border p-4 rounded-lg">
                                <h4 class="text-xl font-semibold"><?php echo htmlspecialchars($item['name']); ?></h4>
                                <p class="text-gray-600"><?php echo htmlspecialchars($item['description'] ?: 'No description'); ?></p>
                                <form method="POST" action="" class="mt-4">
                                    <input type="hidden" name="equipment_id" value="<?php echo $item['equipment_id']; ?>">
                                    <button type="submit" name="borrow" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Borrow</button>
                                </form>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Add Equipment (Admin Only) -->
    <?php if ($_SESSION['role'] === 'admin'): ?>
        <section class="py-10">
            <div class="container mx-auto max-w-md">
                <div class="bg-white p-8 rounded-lg shadow-md">
                    <h3 class="text-lg font-semibold mb-4">Add New Equipment</h3>
                    <form method="POST" action="">
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700">Equipment Name</label>
                            <input type="text" id="name" name="name" class="w-full p-2 border rounded-lg" required>
                        </div>
                        <div class="mb-6">
                            <label for="description" class="block text-gray-700">Description</label>
                            <textarea id="description" name="description" class="w-full p-2 border rounded-lg"></textarea>
                        </div>
                        <button type="submit" name="add_equipment" class="w-full bg-blue-600 text-white p-2 rounded-lg hover:bg-blue-700">Add Equipment</button>
                    </form>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- Borrowing History -->
    <section class="py-10">
        <div class="container mx-auto">
            <h3 class="text-xl font-bold mb-6 text-center">Your Borrowing History</h3>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <?php if (empty($borrowing_history)): ?>
                    <p class="text-center">No borrowing history.</p>
                <?php else: ?>
                    <table class="w-full table-auto">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="p-2">Equipment</th>
                                <th class="p-2">Borrow Date</th>
                                <th class="p-2">Return Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($borrowing_history as $item): ?>
                                <tr>
                                    <td class="p-2"><?php echo htmlspecialchars($item['name']); ?></td>
                                    <td class="p-2"><?php echo htmlspecialchars($item['borrow_date']); ?></td>
                                    <td class="p-2"><?php echo htmlspecialchars($item['return_date']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6">
        <div class="container mx-auto text-center">
            <p>© 2025 Electronics Laboratory. All rights reserved.</p>
            <a href="about.php" class="text-blue-300">About Us</a>
        </div>
    </footer>
</body>
</html>