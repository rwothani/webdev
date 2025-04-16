<!-- about.php -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>About Us | Soroti Web Design Hub</title>
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
        <li><a href="about.php" class="hover:underline font-semibold">About</a></li>
        <li><a href="contact.php" class="hover:underline">Contact</a></li>
      </ul>
    </nav>
  </header>

  <!-- Main -->
  <main class="p-10 text-center flex-grow">
    <h2 class="text-3xl font-semibold mb-6">Who We Are</h2>
    <div class="max-w-3xl mx-auto text-gray-700 leading-relaxed">
      <p class="mb-4">
        At Soroti Web Design Hub, we're passionate about unlocking digital potential through hands-on, practical training.
        Founded in the heart of Soroti City, our mission is to empower individuals—students, professionals, and dreamers alike—
        with the skills to build and launch their own websites and applications.
      </p>
      <p class="mb-4">
        With a team of experienced instructors and a curriculum rooted in real-world projects, we make learning web design accessible,
        fun, and future-focused. Whether you're learning HTML for the first time or diving into backend development with PHP,
        we’re here to guide you every step of the way.
      </p>
      <p class="font-bold text-[#228B22] mt-6">
        Let’s build the future of Soroti, one website at a time.
      </p>
    </div>
  </main>

  <!-- Footer -->
  <footer class="bg-black text-white text-center py-4">
    &copy; <?php echo date("Y"); ?> Soroti Web Design Hub. All rights reserved.
  </footer>

</body>

</html>
