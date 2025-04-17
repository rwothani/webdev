<?php
session_start();
require_once 'config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contact'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    if (empty($name) || empty($email) || empty($message)) {
        $error = 'Please fill in all fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email format.';
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)");
            $stmt->execute([$name, $email, $message]);
            $success = 'Your message has been sent successfully!';
        } catch (PDOException $e) {
            $error = 'An error occurred. Please try again.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Electronics Laboratory</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-blue-600 p-4 text-white">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold">Electronics Lab</h1>
            <div>
                <a href="index.php" class="mr-4">Home</a>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="dashboard.php" class="mr-4">Dashboard</a>
                    <a href="schedule.php" class="mr-4">Schedule Practicals</a>
                    <a href="equipment.php" class="mr-4">Borrow Equipment</a>
                    <a href="study-room.php" class="mr-4">Book Study Room</a>
                    <?php if ($_SESSION['role'] === 'admin'): ?>
                        <a href="admin.php" class="mr-4">Admin Panel</a>
                    <?php endif; ?>
                    <a href="logout.php">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="mr-4">Login</a>
                    <a href="register.php">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- About Section -->
    <section class="py-10">
        <div class="container mx-auto">
            <h2 class="text-2xl font-bold mb-6 text-center">About the Electronics Laboratory</h2>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <p class="mb-4">The Electronics Laboratory at our institution is a state-of-the-art facility designed to support hands-on learning and research in electronics and electrical engineering. Equipped with modern tools and instruments, the lab provides students and faculty with the resources to conduct experiments, develop projects, and explore innovative solutions.</p>
                <h3 class="text-xl font-semibold mb-2">Lab Rules</h3>
                <ul class="list-disc pl-6 mb-4">
                    <li>Always follow safety protocols when using equipment.</li>
                    <li>Return borrowed equipment in good condition.</li>
                    <li>Book practical sessions and study time in advance.</li>
                    <li>No food or drinks allowed in the lab.</li>
                </ul>
                <h3 class="text-xl font-semibold mb-2">Operating Hours</h3>
                <p class="mb-4">Monday–Friday: 9:00 AM–5:00 PM<br>Saturday: 10:00 AM–2:00 PM<br>Closed on Sundays and holidays.</p>
                <h3 class="text-xl font-semibold mb-2">Staff</h3>
                <p>Lab Manager: Dr. John Smith<br>Technicians: Jane Doe, Alex Brown</p>
            </div>
        </div>
    </section>

    <!-- Contact Form -->
    <section class="py-10">
        <div class="container mx-auto max-w-md">
            <div class="bg-white p-8 rounded-lg shadow-md">
                <h3 class="text-xl font-semibold mb-4">Contact Us</h3>
                <?php if ($error): ?>
                    <p class="text-red-500 text-center mb-4"><?php echo htmlspecialchars($error); ?></p>
                <?php endif; ?>
                <?php if ($success): ?>
                    <p class="text-green-500 text-center mb-4"><?php echo htmlspecialchars($success); ?></p>
                <?php endif; ?>
                <form method="POST" action="">
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700">Name</label>
                        <input type="text" id="name" name="name" class="w-full p-2 border rounded-lg" required>
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700">Email</label>
                        <input type="email" id="email" name="email" class="w-full p-2 border rounded-lg" required>
                    </div>
                    <div class="mb-6">
                        <label for="message" class="block text-gray-700">Message</label>
                        <textarea id="message" name="message" class="w-full p-2 border rounded-lg" rows="5" required></textarea>
                    </div>
                    <button type="submit" name="contact" class="w-full bg-blue-600 text-white p-2 rounded-lg hover:bg-blue-700">Send Message</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6">
        <div class="container mx-auto text-center">
            <p>© 2025 Electronics Laboratory. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>