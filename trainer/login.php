<!-- login.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login | Soroti Web Design Hub</title>
  <!-- <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"> -->
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

</head>
<body class="bg-white text-black">
  <div class="min-h-screen flex items-center justify-center">
    <div class="flex flex-col md:flex-row shadow-lg rounded-lg overflow-hidden w-full max-w-4xl">
      
      <!-- Left Image -->
      <div class="md:w-1/2 hidden md:block">
      <img src="https://images.unsplash.com/photo-1556761175-5973dc0f32e7" 
             alt="Login Illustration" 
             class="h-full w-full object-cover" />
      </div>

      <!-- Right Form -->
      <div class="md:w-1/2 bg-white p-10">
        <h2 class="text-3xl font-bold text-[#228B22] mb-6">Login</h2>
        <form action="loginhandler.php" method="POST" class="space-y-4">
          <div>
            <label class="block font-semibold">Username</label>
            <input type="text" name="username" required class="w-full border border-gray-300 p-2 rounded" />
          </div>

          <div>
            <label class="block font-semibold">Password</label>
            <input type="password" name="password" required class="w-full border border-gray-300 p-2 rounded" />
          </div>

          <button type="submit" class="w-full bg-[#228B22] text-white py-2 rounded hover:bg-black hover:text-white transition">
            Login
          </button>
        </form>

        <p class="mt-4 text-sm text-gray-600">Don't have an account? <a href="register.php" class="text-[#228B22] hover:underline">Register here</a>.</p>
      </div>
    </div>
  </div>
</body>
</html>
