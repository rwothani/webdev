<!-- register.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Register | Soroti Web Design Hub</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white text-black">
  <div class="min-h-screen flex items-center justify-center">
    <div class="flex flex-col md:flex-row shadow-lg rounded-lg overflow-hidden w-full max-w-5xl">
      
      <!-- Left Image Section -->
      <div class="md:w-1/2 hidden md:block">
        <img src="https://images.unsplash.com/photo-1556761175-5973dc0f32e7" 
             alt="Registration Illustration" 
             class="h-full w-full object-cover" />
      </div>

      <!-- Right Form Section -->
      <div class="md:w-1/2 bg-white p-10">
        <h2 class="text-3xl font-bold text-[#228B22] mb-6">Register Now</h2>
        <form action="registerhandler.php" method="POST" class="space-y-4">
          <div>
            <label class="block font-semibold">Full Name</label>
            <input type="text" name="name" required class="w-full border border-gray-300 p-2 rounded" />
          </div>

          <div>
            <label class="block font-semibold">Phone Number</label>
            <input type="text" name="phone" required class="w-full border border-gray-300 p-2 rounded" />
          </div>

          <div>
            <label class="block font-semibold">Email</label>
            <input type="email" name="email" required class="w-full border border-gray-300 p-2 rounded" />
          </div>

          <div>
            <label class="block font-semibold">Address</label>
            <input type="text" name="address" required class="w-full border border-gray-300 p-2 rounded" />
          </div>

          <div>
            <label class="block font-semibold">Username</label>
            <input type="text" name="username" required class="w-full border border-gray-300 p-2 rounded" />
          </div>

          <div>
            <label class="block font-semibold">Password</label>
            <input type="password" name="password" required class="w-full border border-gray-300 p-2 rounded" />
          </div>

          <button type="submit" class="w-full bg-[#228B22] text-white py-2 rounded hover:bg-black transition">
            Register
          </button>
        </form>

        <p class="mt-4 text-sm text-gray-600">Already registered? <a href="login.php" class="text-[#228B22] hover:underline">Login here</a>.</p>
      </div>
    </div>
  </div>
</body>
</html>
