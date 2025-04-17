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

// Handle cancellation of practicals
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel_practical'])) {
    $session_id = $_POST['session_id'];
    try {
        $stmt = $pdo->prepare("UPDATE practicals SET status = 'cancelled' WHERE session_id = ? AND user_id = ?");
        $stmt->execute([$session_id, $_SESSION['user_id']]);
        $success = 'Practical session cancelled successfully!';
    } catch (PDOException $e) {
        $error = 'An error occurred. Please try again.';
    }
}

// Handle cancellation of study bookings
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel_study'])) {
    $booking_id = $_POST['booking_id'];
    try {
        $stmt = $pdo->prepare("UPDATE study_bookings SET status = 'cancelled' WHERE booking_id = ? AND user_id = ?");
        $stmt->execute([$booking_id, $_SESSION['user_id']]);
        $success = 'Study booking cancelled successfully!';
    } catch (PDOException $e) {
        $error = 'An error occurred. Please try again.';
    }
}

// Fetch user's practicals
$stmt = $pdo->prepare("SELECT * FROM practicals WHERE user_id = ? AND status = 'confirmed' AND date >= CURDATE() ORDER BY date, start_time");
$stmt->execute([$_SESSION['user_id']]);
$practicals = $stmt->fetchAll();

// Fetch user's borrowed equipment
$stmt = $pdo->prepare("SELECT * FROM equipment WHERE borrower_id = ? AND status = 'borrowed' ORDER BY borrow_date DESC");
$stmt->execute([$_SESSION['user_id']]);
$equipment = $stmt->fetchAll();

// Fetch user's study bookings
$stmt = $pdo->prepare("SELECT * FROM study_bookings WHERE user_id = ? AND status = 'confirmed' AND date >= CURDATE() ORDER BY date, start_time");
$stmt->execute([$_SESSION['user_id']]);
$study_bookings = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Electronics Laboratory</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-blue-600 p-4 text-white">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold">Electronics Lab</h1>
            <div>
                <a href="index.php" class="mr-4">Home</a>
                <a href="schedule.php" class="mr-4">Schedule Practicals</a>
                <a href="equipment.php" class="mr-4">Borrow Equipment</a>
                <a href="study_room.php" class="mr-4">Book Study Room</a>
                <?php if ($_SESSION['role'] === 'admin'): ?>
                    <a href="admin.php" class="mr-4">Admin Panel</a>
                <?php endif; ?>
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Dashboard -->
    <section class="py-10">
        <div class="container mx-auto">
            <h2 class="text-2xl font-bold mb-6 text-center">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
            <?php if ($error): ?>
                <p class="text-red-500 text-center mb-4"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
            <?php if ($success): ?>
                <p class="text-green-500 text-center mb-4"><?php echo htmlspecialchars($success); ?></p>
            <?php endif; ?>
            
            <!-- Practicals -->
            <div class="mb-10">
                <h3 class="text-xl font-semibold mb-4">Your Upcoming Practicals</h3>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <?php if (empty($practicals)): ?>
                        <p class="text-center">No upcoming practicals.</p>
                    <?php else: ?>
                        <table class="w-full table-auto">
                            <thead>
                                <tr class="bg-gray-200">
                                    <th class="p-2">Experiment</th>
                                    <th class="p-2">Date</th>
                                    <th class="p-2">Time</th>
                                    <th class="p-2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($practicals as $practical): ?>
                                    <tr>
                                        <td class="p-2"><?php echo htmlspecialchars($practical['experiment_name']); ?></td>
                                        <td class="p-2"><?php echo htmlspecialchars($practical['date']); ?></td>
                                        <td class="p-2"><?php echo htmlspecialchars($practical['start_time'] . ' - ' . $practical['end_time']); ?></td>
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
                    <?php endif; ?>
                </div>
            </div>

            <!-- Borrowed Equipment -->
            <div class="mb-10">
                <h3 class="text-xl font-semibold mb-4">Your Borrowed Equipment</h3>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <?php if (empty($equipment)): ?>
                        <p class="text-center">No borrowed equipment.</p>
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
                                <?php foreach ($equipment as $item): ?>
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

            <!-- Study Bookings -->
            <div>
                <h3 class="text-xl font-semibold mb-4">Your Study Bookings</h3>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <?php if (empty($study_bookings)): ?>
                        <p class="text-center">No study bookings.</p>
                    <?php else: ?>
                        <table class="w-full table-auto">
                            <thead>
                                <tr class="bg-gray-200">
                                    <th class="p-2">Date</th>
                                    <th class="p-2">Time</th>
                                    <th class="p-2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($study_bookings as $booking): ?>
                                    <tr>
                                        <td class="p-2"><?php echo htmlspecialchars($booking['date']); ?></td>
                                        <td class="p-2"><?php echo htmlspecialchars($booking['start_time'] . ' - ' . $booking['end_time']); ?></td>
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
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6">
        <div class="container mx-auto text-center">
            <p>© 2025 Electronics Laboratory. All rights reserved.</p>
            <a href="about_us.php" class="text-blue-300">About Us</a>
        </div>
    </footer>
</body>
</html>