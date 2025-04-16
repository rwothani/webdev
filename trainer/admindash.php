<?php
include('database.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard | Soroti Web Design Hub</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen text-gray-900">
  <header class="bg-[#228B22] text-white p-12 shadow-md">
    <h1 class="text-2xl font-bold">Admin Dashboard</h1>
  </header>

  <main class="p-8 space-y-10">

    <!-- Section: Dashboard Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
      <!-- Registered Users -->
      <div class="bg-white p-6 rounded shadow">
        <h2 class="text-xl font-semibold mb-2">Registered Users</h2>
        <?php
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM users");
        $row = $stmt->fetch();
        echo "<p class='text-3xl font-bold'>{$row['total']}</p>";
        ?>
      </div>

      <!-- Borrowed Books -->
      <div class="bg-white p-6 rounded shadow">
        <h2 class="text-xl font-semibold mb-2">Borrowed Books</h2>
        <?php
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM books WHERE status = 'borrowed'");
        $row = $stmt->fetch();
        echo "<p class='text-3xl font-bold'>{$row['total']}</p>";
        ?>
      </div>

      <!-- Punished Users -->
      <div class="bg-white p-6 rounded shadow">
        <h2 class="text-xl font-semibold mb-2">Punished Users</h2>
        <?php
        $stmt = $pdo->query("SELECT COUNT(DISTINCT borrowed_by) as total FROM books WHERE returned_on IS NULL AND borrowed_on < DATE_SUB(CURDATE(), INTERVAL 14 DAY)");
        $row = $stmt->fetch();
        echo "<p class='text-3xl font-bold'>{$row['total']}</p>";
        ?>
      </div>

      <!-- Total Courses -->
      <div class="bg-white p-6 rounded shadow">
        <h2 class="text-xl font-semibold mb-2">Available Courses</h2>
        <?php
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM trainings");
        $row = $stmt->fetch();
        echo "<p class='text-3xl font-bold'>{$row['total']}</p>";
        ?>
      </div>
    </div>

    <!-- Section: Courses Table -->
    <div class="bg-white p-6 rounded shadow">
      <h2 class="text-2xl font-semibold mb-4">Available Courses & Prices</h2>
      <table class="w-full text-left border border-gray-300">
        <thead class="bg-gray-100">
          <tr>
            <th class="py-2 px-4 border-b">#</th>
            <th class="py-2 px-4 border-b">Course Title</th>
            <th class="py-2 px-4 border-b">Description</th>
            <th class="py-2 px-4 border-b">Price (UGX)</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $stmt = $pdo->query("SELECT * FROM trainings");
          $i = 1;
          while ($row = $stmt->fetch()) {
            echo "<tr class='hover:bg-gray-50'>";
            echo "<td class='py-2 px-4 border-b'>{$i}</td>";
            echo "<td class='py-2 px-4 border-b'>{$row['title']}</td>";
            echo "<td class='py-2 px-4 border-b'>{$row['description']}</td>";
            echo "<td class='py-2 px-4 border-b'>" . number_format($row['cost']) . "</td>";
            echo "</tr>";
            $i++;
          }
          ?>
        </tbody>
      </table>
    </div>

  </main>
</body>

</html>
