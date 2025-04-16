<!-- index.php -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Web Design Training | Soroti City</title>
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

  <!-- Hero Image -->
  <div class="w-full">
    <img src="https://unsplash.com/photos/green-painted-wall-WsL5PhqlGaU" 
    alt="Web Design Training Banner" 
    class="w-full h-64 object-cover" />
  </div>

  <!-- Main Content -->
  <main class="flex-grow p-10 text-center">
    <h2 class="text-3xl font-semibold mb-4">Welcome to Soroti's Premier Web Design Training</h2>
    <p class="text-gray-700 max-w-2xl mx-auto">
      We provide hands-on training in web technologies such as PHP, HTML, CSS, and more.
      Whether you're a beginner or looking to upskill, we've got the right course for you.
    </p>
    <a href="register.php" class="mt-6 inline-block bg-black text-white px-6 py-3 rounded hover:bg-[#228B22] transition duration-300">
      Get Started
    </a>
  </main>

  <!-- Footer -->
  <footer class="bg-black text-white text-center py-4">
    &copy; <?php echo date("Y"); ?> Soroti Web Design Hub. All rights reserved.
  </footer>

</body>

</html>
