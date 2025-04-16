<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!-- training.php -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Trainings | Soroti Web Design Hub</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-white text-black flex flex-col min-h-screen">

  <!-- Header -->
  <header class="bg-[#228B22] text-white p-6 md:p-12 flex flex-col md:flex-row justify-between items-center shadow-md">
    <h1 class="text-2xl font-bold">Soroti Web Design Hub</h1>
    <nav class="mt-4 md:mt-0">
      <ul class="flex flex-wrap justify-center md:space-x-10 space-x-4">
        <li><a href="index.php" class="hover:underline">Home</a></li>
        <li><a href="training.php" class="hover:underline">Trainings</a></li>
        <li><a href="register.php" class="hover:underline">Register</a></li>
        <li><a href="login.php" class="hover:underline">Login</a></li>
        <li><a href="about.php" class="hover:underline">About</a></li>
        <li><a href="contact.php" class="hover:underline">Contact</a></li>
      </ul>
    </nav>
  </header>

  <!-- Main -->
  <main class="p-10 text-center flex-grow">
    <h2 class="text-3xl font-semibold mb-6">Our Trainings</h2>
    <p class="text-gray-700 max-w-xl mx-auto mb-8">
      Whether you're a complete beginner or looking to sharpen your web skills, our training programs are designed to get you there.
    </p>

    <div class="grid md:grid-cols-3 gap-8">
      <!-- Training Card -->
      <div class="bg-gray-100 p-6 rounded-xl shadow hover:shadow-lg">
        <h3 class="text-xl font-bold mb-2">HTML & CSS</h3>
        <p class="text-gray-600">Learn how to structure and style websites from scratch. Perfect for beginners.</p>
      </div>

      <div class="bg-gray-100 p-6 rounded-xl shadow hover:shadow-lg">
        <h3 class="text-xl font-bold mb-2">JavaScript Basics</h3>
        <p class="text-gray-600">Bring your websites to life with dynamic, interactive features using JS.</p>
      </div>

      <div class="bg-gray-100 p-6 rounded-xl shadow hover:shadow-lg">
        <h3 class="text-xl font-bold mb-2">PHP & MySQL</h3>
        <p class="text-gray-600">Build functional, database-driven web applications using PHP and MySQL.</p>
      </div>

      <div class="bg-gray-100 p-6 rounded-xl shadow hover:shadow-lg">
        <h3 class="text-xl font-bold mb-2">Responsive Design</h3>
        <p class="text-gray-600">Ensure your websites work beautifully on all devices with responsive techniques.</p>
      </div>

      <div class="bg-gray-100 p-6 rounded-xl shadow hover:shadow-lg">
        <h3 class="text-xl font-bold mb-2">Git & GitHub</h3>
        <p class="text-gray-600">Version control made simple. Collaborate on code like a pro.</p>
      </div>

      <div class="bg-gray-100 p-6 rounded-xl shadow hover:shadow-lg">
        <h3 class="text-xl font-bold mb-2">Capstone Project</h3>
        <p class="text-gray-600">Apply everything you've learned to build a complete website from scratch.</p>
      </div>
    </div>

    <a href="register.php" class="mt-10 inline-block bg-black text-white px-6 py-3 rounded hover:bg-[#228B22] transition duration-300">
      Register Now
    </a>
  </main>

  <!-- Footer -->
  <footer class="bg-black text-white text-center py-4">
    &copy; <?php echo date("Y"); ?> Soroti Web Design Hub. All rights reserved.
  </footer>

</body>

</html>
