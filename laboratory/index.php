<?php
session_start();
require_once 'config.php'; // Database connection (PDO setup)
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Electronics Laboratory</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-blue-600 p-4 text-white">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold">Electronics Lab</h1>
            <div>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="dashboard.php" class="mr-4">Dashboard</a>
                    <a href="logout.php">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="mr-4">Login</a>
                    <a href="register.php">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-blue-500 text-white py-20">
        <div class="container mx-auto text-center">
            <h2 class="text-4xl font-bold mb-4">Welcome to the Electronics Laboratory</h2>
            <p class="text-lg mb-6">Schedule practicals, borrow equipment, or book study sessions.</p>
            <div class="space-x-4">
                <a href="schedule.php" class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold">Schedule Practicals</a>
                <a href="equipment.php" class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold">Borrow Equipment</a>
                <a href="study-room.php" class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold">Book Study Room</a>
            </div>
        </div>
    </section>

    <!-- Announcements -->
    <section class="py-10">
        <div class="container mx-auto">
            <h3 class="text-2xl font-bold mb-6 text-center">Announcements</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php
                $stmt = $pdo->query("SELECT * FROM announcements ORDER BY posted_at DESC LIMIT 3");
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '<div class="bg-white p-6 rounded-lg shadow-md">';
                    echo '<h4 class="text-xl font-semibold mb-2">' . htmlspecialchars($row['title']) . '</h4>';
                    echo '<p>' . htmlspecialchars($row['content']) . '</p>';
                    echo '<p class="text-sm text-gray-500 mt-2">' . $row['posted_at'] . '</p>';
                    echo '</div>';
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6">
        <div class="container mx-auto text-center">
            <p>&copy; 2025 Electronics Laboratory. All rights reserved.</p>
            <a href="about_us.php" class="text-blue-300">About Us</a>
        </div>
    </footer>
</body>
</html>