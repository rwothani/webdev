<?php
session_start();
require_once 'config.php';

// Redirect if not admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$error = '';
$success = '';

// Handle user deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user'])) {
    $user_id = $_POST['user_id'];
    try {
        $stmt = $pdo->prepare("DELETE FROM users WHERE user_id = ? AND role != 'admin'");
        $stmt->execute([$user_id]);
        $success = 'User deleted successfully!';
    } catch (PDOException $e) {
        $error = 'An error occurred. Please try again.';
    }
}

// Handle practical cancellation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel_practical'])) {
    $session_id = $_POST['session_id'];
    try {
        $stmt = $pdo->prepare("UPDATE practicals SET status = 'cancelled' WHERE session_id = ?");
        $stmt->execute([$session_id]);
        $success = 'Practical session cancelled successfully!';
    } catch (PDOException $e) {
        $error = 'An error occurred. Please try again.';
    }
}

// Handle study booking cancellation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel_study'])) {
    $booking_id = $_POST['booking_id'];
    try {
        $stmt = $pdo->prepare("UPDATE study_bookings SET status = 'cancelled' WHERE booking_id = ?");
        $stmt->execute([$booking_id]);
        $success = 'Study booking cancelled successfully!';
    } catch (PDOException $e) {
        $error = 'An error occurred. Please try again.';
    }
}

// Handle equipment status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_equipment'])) {
    $equipment_id = $_POST['equipment_id'];
    $status = $_POST['status'];
    try {
        $stmt = $pdo->prepare("UPDATE equipment SET status = ?, borrower_id = NULL, borrow_date = NULL, return_date = NULL WHERE equipment_id = ?");
        $stmt->execute([$status, $equipment_id]);
        $success = 'Equipment status updated successfully!';
    } catch (PDOException $e) {
        $error = 'An error occurred. Please try again.';
    }
}

// Fetch all users
$stmt = $pdo->query("SELECT * FROM users ORDER BY username");
$users = $stmt->fetchAll();

// Fetch all practicals
$stmt = $pdo->query("SELECT p.*, u.username FROM practicals p JOIN users u ON p.user_id = u.user_id WHERE p.status = 'confirmed' ORDER BY p.date, p.start_time");
$practicals = $stmt->fetchAll();

// Fetch all study bookings
$stmt = $pdo->query("SELECT s.*, u.username FROM study_bookings s JOIN users u ON s.user_id = u.user_id WHERE s.status = 'confirmed' ORDER BY s.date, s.start_time");
$study_bookings = $stmt->fetchAll();

// Fetch all equipment
$stmt = $pdo->query("SELECT e.*, u.username FROM equipment e LEFT JOIN users u ON e.borrower_id = u.user_id ORDER BY e.name");
$equipment = $stmt->fetchAll();

// Fetch basic report (e.g., booking counts)
$stmt = $pdo->query("SELECT COUNT(*) as practical_count FROM practicals WHERE status = 'confirmed'");
$practical_count = $stmt->fetchColumn();
$stmt = $pdo->query("SELECT COUNT(*) as study_count FROM study_bookings WHERE status = 'confirmed'");
$study_count = $stmt->fetchColumn();
$stmt = $pdo->query("SELECT COUNT(*) as equipment_borrowed FROM equipment WHERE status = 'borrowed'");
$equipment_borrowed = $stmt->fetchColumn();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Electronics Laboratory</title>
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
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Admin Panel -->
    <section class="py-10">
        <div class="container mx-auto">
            <h2 class="text-2xl font-bold mb-6 text-center">Admin Panel</h2>
            <?php if ($error): ?>
                <p class="text-red-500 text-center mb-4"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
            <?php if ($success): ?>
                <p class="text-green-500 text-center mb-4"><?php echo htmlspecialchars($success); ?></p>
            <?php endif; ?>
            
            <!-- Tabs -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="flex border-b">
                    <button class="px-4 py-2 font-semibold text-blue-600 border-b-2 border-blue-600" onclick="showTab('users')">Users</button>
                    <button class="px-4 py-2 font-semibold text-gray-600" onclick="showTab('practicals')">Practicals</button>
                    <button class="px-4 py-2 font-semibold text-gray-600" onclick="showTab('study')">Study Bookings</button>
                    <button class="px-4 py-2 font-semibold text-gray-600" onclick="showTab('equipment')">Equipment</button>
                    <button class="px-4 py-2 font-semibold text-gray-600" onclick="showTab('reports')">Reports</button>
                </div>

                <!-- Users Tab -->
                <div id="users" class="tab-content">
                    <h3 class="text-xl font-semibold mb-4">Manage Users</h3>
                    <table class="w-full table-auto">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="p-2">Username</th>
                                <th class="p-2">Email</th>
                                <th class="p-2">Role</th>
                                <th class="p-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td class="p-2"><?php echo htmlspecialchars($user['username']); ?></td>
                                    <td class="p-2"><?php echo htmlspecialchars($user['email']); ?></td>
                                    <td class="p-2"><?php echo htmlspecialchars($user['role']); ?></td>
                                    <td class="p-2">
                                        <?php if ($user['role'] !== 'admin'): ?>
                                            <form method="POST" action="" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                                                <button type="submit" name="delete_user" class="text-red-500 hover:underline">Delete</button>
                                            </form>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Practicals Tab -->
                <div id="practicals" class="tab-content hidden">
                    <h3 class="text-xl font-semibold mb-4">Manage Practicals</h3>
                    <table class="w-full table-auto">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="p-2">Experiment</th>
                                <th class="p-2">Date</th>
                                <th class="p-2">Time</th>
                                <th class="p-2">User</th>
                                <th class="p-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($practicals as $practical): ?>
                                <tr>
                                    <td class="p-2"><?php echo htmlspecialchars($practical['experiment_name']); ?></td>
                                    <td class="p-2"><?php echo htmlspecialchars($practical['date']); ?></td>
                                    <td class="p-2"><?php echo htmlspecialchars($practical['start_time'] . ' - ' . $practical['end_time']); ?></td>
                                    <td class="p-2"><?php echo htmlspecialchars($practical['username']); ?></td>
                                    <td class="p-2">
                                        <form method="POST" action="" onsubmit="return confirm('Are you sure you want to cancel this practical?');">
                                            <input type="hidden" name="session_id" value="<?php echo $practical['session_id']; ?>">
                                            <button type="submit" name="cancel_practical" class="text-red-500 hover:underline">Cancel</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Study Bookings Tab -->
                <div id="study" class="tab-content hidden">
                    <h3 class="text-xl font-semibold mb-4">Manage Study Bookings</h3>
                    <table class="w-full table-auto">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="p-2">Date</th>
                                <th class="p-2">Time</th>
                                <th class="p-2">User</th>
                                <th class="p-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($study_bookings as $booking): ?>
                                <tr>
                                    <td class="p-2"><?php echo htmlspecialchars($booking['date']); ?></td>
                                    <td class="p-2"><?php echo htmlspecialchars($booking['start_time'] . ' - ' . $booking['end_time']); ?></td>
                                    <td class="p-2"><?php echo htmlspecialchars($booking['username']); ?></td>
                                    <td class="p-2">
                                        <form method="POST" action="" onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                                            <input type="hidden" name="booking_id" value="<?php echo $booking['booking_id']; ?>">
                                            <button type="submit" name="cancel_study" class="text-red-500 hover:underline">Cancel</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Equipment Tab -->
                <div id="equipment" class="tab-content hidden">
                    <h3 class="text-xl font-semibold mb-4">Manage Equipment</h3>
                    <table class="w-full table-auto">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="p-2">Equipment</th>
                                <th class="p-2">Status</th>
                                <th class="p-2">Borrower</th>
                                <th class="p-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($equipment as $item): ?>
                                <tr>
                                    <td class="p-2"><?php echo htmlspecialchars($item['name']); ?></td>
                                    <td class="p-2"><?php echo htmlspecialchars($item['status']); ?></td>
                                    <td class="p-2"><?php echo htmlspecialchars($item['username'] ?: 'None'); ?></td>
                                    <td class="p-2">
                                        <form method="POST" action="">
                                            <input type="hidden" name="equipment_id" value="<?php echo $item['equipment_id']; ?>">
                                            <select name="status" class="p-1 border rounded">
                                                <option value="available" <?php echo $item['status'] === 'available' ? 'selected' : ''; ?>>Available</option>
                                                <option value="borrowed" <?php echo $item['status'] === 'borrowed' ? 'selected' : ''; ?>>Borrowed</option>
                                                <option value="maintenance" <?php echo $item['status'] === 'maintenance' ? 'selected' : ''; ?>>Maintenance</option>
                                            </select>
                                            <button type="submit" name="update_equipment" class="text-blue-500 hover:underline">Update</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Reports Tab -->
                <div id="reports" class="tab-content hidden">
                    <h3 class="text-xl font-semibold mb-4">Reports</h3>
                    <div class="bg-gray-100 p-4 rounded-lg">
                        <p><strong>Total Confirmed Practicals:</strong> <?php echo $practical_count; ?></p>
                        <p><strong>Total Confirmed Study Bookings:</strong> <?php echo $study_count; ?></p>
                        <p><strong>Total Borrowed Equipment:</strong> <?php echo $equipment_borrowed; ?></p>
                    </div>
                </div>
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

    <!-- Tab Script -->
    <script>
        function showTab(tabId) {
            document.querySelectorAll('.tab-content').forEach(tab => tab.classList.add('hidden'));
            document.getElementById(tabId).classList.remove('hidden');
            document.querySelectorAll('button').forEach(btn => {
                btn.classList.remove('text-blue-600', 'border-b-2', 'border-blue-600');
                btn.classList.add('text-gray-600');
            });
            document.querySelector(`button[onclick="showTab('${tabId}')"]`).classList.add('text-blue-600', 'border-b-2', 'border-blue-600');
        }
    </script>
</body>
</html>