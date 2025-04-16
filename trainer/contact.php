<!-- contact.php -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Contact Us | Soroti Web Design Hub</title>
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
        <li><a href="contact.php" class="hover:underline font-semibold">Contact</a></li>
      </ul>
    </nav>
  </header>

  <!-- Main -->
  <main class="p-10 flex-grow">
    <h2 class="text-3xl text-center font-semibold mb-6">Get In Touch</h2>

    <div class="grid md:grid-cols-2 gap-10 max-w-5xl mx-auto">

      <!-- Contact Form -->
      <form action="#" method="POST" class="bg-gray-100 p-8 rounded-xl shadow space-y-4">
        <div>
          <label for="name" class="block mb-1 font-medium">Name</label>
          <input type="text" id="name" name="name" required class="w-full border border-gray-300 rounded px-3 py-2" />
        </div>
        <div>
          <label for="email" class="block mb-1 font-medium">Email</label>
          <input type="email" id="email" name="email" required class="w-full border border-gray-300 rounded px-3 py-2" />
        </div>
        <div>
          <label for="message" class="block mb-1 font-medium">Message</label>
          <textarea id="message" name="message" rows="4" required class="w-full border border-gray-300 rounded px-3 py-2"></textarea>
        </div>
        <button type="submit" class="bg-[#228B22] text-white px-6 py-2 rounded hover:bg-black transition">
          Send Message
        </button>
      </form>

      <!-- Contact Info -->
      <div class="text-gray-700 space-y-4">
        <h3 class="text-xl font-semibold">Visit Us</h3>
        <p>Soroti Web Design Hub<br>Soroti City, Eastern Uganda</p>

        <h3 class="text-xl font-semibold">Call or WhatsApp</h3>
        <p>+256 700 123 456</p>

        <h3 class="text-xl font-semibold">Email</h3>
        <p>info@sorotiwebhub.ug</p>

        <h3 class="text-xl font-semibold">Follow Us</h3>
        <p>
          <a href="#" class="text-[#228B22] hover:underline">Facebook</a> |
          <a href="#" class="text-[#228B22] hover:underline">Twitter</a> |
          <a href="#" class="text-[#228B22] hover:underline">Instagram</a>
        </p>
      </div>

    </div>
  </main>

  <!-- Footer -->
  <footer class="bg-black text-white text-center py-4">
    &copy; <?php echo date("Y"); ?> Soroti Web Design Hub. All rights reserved.
  </footer>

</body>

</html>
