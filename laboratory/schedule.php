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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['book'])) {
    $experiment_name = trim($_POST['experiment_name']);
    $date = $_POST['date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    // Validate input
    if (empty($experiment_name) || empty($date) || empty($start_time) || empty($end_time)) {
        $error = 'Please fill in all fields.';
    } elseif (strtotime($end_time) <= strtotime($start_time)) {
        $error = 'End time must be after start time.';
    } elseif (strtotime($date) < strtotime(date('Y-m-d'))) {
        $error = 'Cannot book past dates.';
    } else {
        try {
            // Check for overlapping bookings
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM practicals WHERE date = ? AND status = 'confirmed' AND (
                (start_time <= ? AND end_time > ?) OR 
                (start_time < ? AND end_time >= ?) OR
                (start_time >= ? AND end_time <= ?)
            )");
            $stmt->execute([$date, $start_time, $start_time, $end_time, $end_time, $start_time, $end_time]);
            if ($stmt->fetchColumn() > 0) {
                $error = 'This time slot is already booked.';
            } else {
                // Insert booking
                $stmt = $pdo->prepare("INSERT INTO practicals (user_id, experiment_name, date, start_time, end_time, status) VALUES (?, ?, ?, ?, ?, 'confirmed')");
                $stmt->execute([$_SESSION['user_id'], $experiment_name, $date, $start_time, $end_time]);
                $success = 'Practical session booked successfully!';
            }
        } catch (PDOException $e) {
            $error = 'An error occurred. Please try again.';
        }
    }
}

// Handle cancellation (admin only)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel']) && $_SESSION['role'] === 'admin') {
    $session_id = $_POST['session_id'];
    try {
        $stmt = $pdo->prepare("UPDATE practicals SET status = 'cancelled' WHERE session_id = ?");
        $stmt->execute([$session_id]);
        $success = 'Booking cancelled successfully!';
    } catch (PDOException $e) {
        $error = 'An error occurred. Please try again.';
    }
}

// Fetch all bookings
$stmt = $pdo->query("SELECT p.*, u.username FROM practicals p JOIN users u ON p.user_id = u.user_id WHERE p.status = 'confirmed' ORDER BY p.date, p.start_time");
$bookings = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule Practicals - Electronics Laboratory</title>
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
                <a href="equipment.php" class="mr-4">Borrow Equipment</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Booking Form -->
    <section class="py-10">
        <div class="container mx-auto">
            <h2 class="text-2xl font-bold mb-6 text-center">Schedule a Practical Session</h2>
            <?php if ($error): ?>
                <p class="text-red-500 text-center mb-4"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
            <?php if ($success): ?>
                <p class="text-green-500 text-center mb-4"><?php echo htmlspecialchars($success); ?></p>
            <?php endif; ?>
            <div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-md">
                <form method="POST" action="">
                    <div class="mb-4">
                        <label for="experiment_name" class="block text-gray-700">Experiment Name</label>
                        <input type="text" id="experiment_name" name="experiment_name" class="w-full p-2 border rounded-lg" required>
                    </div>
                    <div class="mb-4">
                        <label for="date" class="block text-gray-700">Date</label>
                        <input type="date" id="date" name="date" class="w-full p-2 border rounded-lg" required>
                    </div>
                    <div class="mb-4">
                        <label for="start_time" class="block text-gray-700">Start Time</label>
                        <input type="time" id="start_time" name="start_time" class="w-full p-2 border rounded-lg" required>
                    </div>
                    <div class="mb-6">
                        <label for="end_time" class="block text-gray-700">End Time</label>
                        <input type="time" id="end_time" name="end_time" class="w-full p-2 border rounded-lg" required>
                    </div>
                    <button type="submit" name="book" class="w-full bg-blue-600 text-white p-2 rounded-lg hover:bg-blue-700">Book Session</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Existing Bookings -->
    <section class="py-10">
        <div class="container mx-auto">
            <h3 class="text-xl font-bold mb-6 text-center">Scheduled Practicals</h3>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <?php if (empty($bookings)): ?>
                    <p class="text-center">No scheduled practicals.</p>
                <?php else: ?>
                    <table class="w-full table-auto">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="p-2">Experiment</th>
                                <th class="p-2">Date</th>
                                <th class="p-2">Time</th>
                                <th class="p-2">User</th>
                                <?php if ($_SESSION['role'] === 'admin'): ?>
                                    <th class="p-2">Action</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($bookings as $booking): ?>
                                <tr>
                                    <td class="p-2"><?php echo htmlspecialchars($booking['experiment_name']); ?></td>
                                    <td class="p-2"><?php echo htmlspecialchars($booking['date']); ?></td>
                                    <td class="p-2"><?php echo htmlspecialchars($booking['start_time'] . ' - ' . $booking['end_time']); ?></td>
                                    <td class="p-2"><?php echo htmlspecialchars($booking['username']); ?></td>
                                    <?php if ($_SESSION['role'] === 'admin'): ?>
                                        <td class="p-2">
                                            <form method="POST" action="" onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                                                <input type="hidden" name="session_id" value="<?php echo $booking['session_id']; ?>">
                                                <button type="submit" name="cancel" class="text-red-500 hover:underline">Cancel</button>
                                            </form>
                                        </td>
                                    <?php endif; ?>
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