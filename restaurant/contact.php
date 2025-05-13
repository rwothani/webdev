<?php
require_once 'config.php';
session_start();

// Generate CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);

    if ($name && $email && $message && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
            $stmt->execute([$name, $email, $message]);
            echo "<script>alert('Message sent successfully!'); window.location.href='/contact.php';</script>";
        } catch (PDOException $e) {
            $error = "Database error: " . htmlspecialchars($e->getMessage());
        }
    } else {
        $error = "Please fill out all fields correctly.";
    }
}
?>

<?php require_once 'header.php'; ?>

<section class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold mb-8 text-center">Contact Us</h1>
        
        <!-- Contact Form -->
        <div class="max-w-lg mx-auto mb-12">
            <form method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                <?php if (isset($error)): ?>
                    <p class="text-red-500 mb-4"><?php echo htmlspecialchars($error); ?></p>
                <?php endif; ?>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1" for="name">Name</label>
                    <input type="text" id="name" name="name" class="w-full border rounded-md p-2" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1" for="email">Email</label>
                    <input type="email" id="email" name="email" class="w-full border rounded-md p-2" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1" for="message">Message</label>
                    <textarea id="message" name="message" class="w-full border rounded-md p-2" rows="5" required></textarea>
                </div>
                <button type="submit" class="bg-yellow-400 text-black px-6 py-3 rounded-md hover:bg-yellow-500 w-full">Send Message</button>
            </form>
        </div>

        <!-- Contact Details -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
            <div>
                <h2 class="text-2xl font-semibold mb-4">Get in Touch</h2>
                <p class="mb-2"><strong>Address:</strong> 123 Flavor Street, Food City, FC 12345</p>
                <p class="mb-2"><strong>Phone:</strong> +1 (555) 123-4567</p>
                <p class="mb-2"><strong>Email:</strong> <a href="mailto:info@palacerestaurant.com" class="text-yellow-400 hover:underline">info@palacerestaurant.com</a></p>
                <p class="mb-2"><strong>Hours:</strong> Mon–Sun, 12:00 PM–10:00 PM</p>
            </div>
            <div>
                <h2 class="text-2xl font-semibold mb-4">Find Us</h2>
                <div class="w-full h-64 rounded-md overflow-hidden">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3153.019435622735!2d-122.41941568468124!3d37.77492977975966!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMzfCsDQ2JzI5LjciTiAxMjLCsDI1JzA5LjkiVw!5e0!3m2!1sen!2sus!4v1634567890123" 
                        width="100%" 
                        height="100%" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'footer.php'; ?>