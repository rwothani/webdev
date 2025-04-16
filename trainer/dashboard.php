<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard | Soroti Web Design Hub</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-white text-black">

<div class="flex h-screen">
  <!-- Sidebar -->
  <div class="w-64 bg-[#228B22] text-white flex flex-col justify-between">
    <div class="p-6">
      <h2 class="text-2xl font-bold mb-6">Dashboard</h2>
      <nav class="space-y-4">
        <a href="dashboard.php" class="block hover:underline">Home</a>
        <a href="training.php" class="block hover:underline">Training Requests</a>
        <a href="profile.php" class="block hover:underline">My Profile</a>
      </nav>
    </div>
    <div class="p-6">
      <a href="logout.php" class="text-sm hover:underline">Logout</a>
    </div>
  </div>

  <!-- Main Content -->
  <div class="flex-1 p-10">
    <h1 class="text-3xl font-bold text-[#228B22] mb-6">Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?> 👋</h1>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      <div class="bg-[#228B22] text-white p-6 rounded-xl shadow-md">
        <h3 class="text-xl font-bold">Total Requests</h3>
        <p class="text-2xl mt-2">12</p> <!-- Replace with dynamic count -->
      </div>
      <div class="bg-black text-white p-6 rounded-xl shadow-md">
        <h3 class="text-xl font-bold">Approved</h3>
        <p class="text-2xl mt-2">5</p>
      </div>
      <div class="bg-white text-black border border-gray-200 p-6 rounded-xl shadow-md">
        <h3 class="text-xl font-bold">Pending</h3>
        <p class="text-2xl mt-2">7</p>
      </div>
    </div>

    <!-- Recent Activity Table -->
    <div class="mt-10">
      <h2 class="text-xl font-bold mb-4">Recent Requests</h2>
      <table class="min-w-full bg-white border border-gray-200">
        <thead>
          <tr class="bg-[#228B22] text-white">
            <th class="py-2 px-4 border">Date</th>
            <th class="py-2 px-4 border">Title</th>
            <th class="py-2 px-4 border">Status</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="py-2 px-4 border">2025-04-15</td>
            <td class="py-2 px-4 border">Web Design Basics</td>
            <td class="py-2 px-4 border">Pending</td>
          </tr>
          <tr>
            <td class="py-2 px-4 border">2025-04-10</td>
            <td class="py-2 px-4 border">JavaScript Bootcamp</td>
            <td class="py-2 px-4 border">Approved</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

</body>
</html>
