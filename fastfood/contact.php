<!-- contact.php -->
<!DOCTYPE html>
<html lang="en">
<?php
session_start();
?>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contact Us | FastFood</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-white text-brown-900">
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

    <section class="relative bg-amber-50 py-16 px-6 md:px-20">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-4xl font-bold mb-6 text-orange-600">Contact Us</h2>
            <p class="mb-10 text-gray-600">Got questions, feedback or just craving something? Reach out!</p>
        </div>

        <div class="grid md:grid-cols-2 gap-12 items-center">
            <!-- Contact Form -->
            <form action="#" method="POST" class="space-y-5 bg-white shadow-xl p-8 rounded-2xl">
                <input type="text" name="name" placeholder="Your Name" required
                    class="w-full p-3 border border-gray-300 rounded-lg" />
                <input type="email" name="email" placeholder="Your Email" required
                    class="w-full p-3 border border-gray-300 rounded-lg" />
                <textarea name="message" rows="4" placeholder="Your Message" required
                    class="w-full p-3 border border-gray-300 rounded-lg"></textarea>
                <button class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-lg font-semibold">Send
                    Message</button>
            </form>

            <!-- Image -->
            <div>
                <img src="burger.jpg" alt="Contact" class="rounded-xl shadow-lg w-full object-cover h-96" />
            </div>
        </div>
    </section>

</body>

</html>