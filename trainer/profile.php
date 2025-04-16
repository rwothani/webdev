<?php
session_start();
include('database.php');

// Redirect to login if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];

// Fetch student info
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch();

// Fetch training requests
$trainingStmt = $pdo->prepare("
    SELECT tr.*, t.title, t.description, t.cost 
    FROM training_requests tr 
    JOIN trainings t ON tr.training_id = t.id 
    WHERE tr.user_id = ?
    ORDER BY tr.requested_at DESC
");
$trainingStmt->execute([$userId]);
$trainingRequests = $trainingStmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Student Profile</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen text-gray-900">
  <header class="bg-[#228B22] text-white p-12 shadow-md">
    <h1 class="text-2xl font-bold">Student Profile</h1>
  </header>

  <main class="p-8 space-y-8 max-w-4xl mx-auto">
    <!-- Profile Information -->
    <section class="bg-white p-6 rounded shadow">
      <h2 class="text-xl font-semibold mb-4">Profile Information</h2>
      <p><strong>Name:</strong> <?= htmlspecialchars($user['username']) ?></p>
      <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
      <p><strong>Joined:</strong> <?= date('F j, Y', strtotime($user['created_at'])) ?></p>
    </section>

    <!-- Training Requests -->
    <section class="bg-white p-6 rounded shadow">
      <h2 class="text-xl font-semibold mb-4">My Training Requests</h2>
      <?php if (count($trainingRequests) > 0): ?>
        <table class="w-full text-left border border-gray-300">
          <thead class="bg-gray-100">
            <tr>
              <th class="py-2 px-4 border-b">#</th>
              <th class="py-2 px-4 border-b">Course</th>
              <th class="py-2 px-4 border-b">Description</th>
              <th class="py-2 px-4 border-b">Price (UGX)</th>
              <th class="py-2 px-4 border-b">Status</th>
              <th class="py-2 px-4 border-b">Requested At</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($trainingRequests as $i => $req): ?>
              <tr class="hover:bg-gray-50">
                <td class="py-2 px-4 border-b"><?= $i + 1 ?></td>
                <td class="py-2 px-4 border-b"><?= htmlspecialchars($req['title']) ?></td>
                <td class="py-2 px-4 border-b"><?= htmlspecialchars($req['description']) ?></td>
                <td class="py-2 px-4 border-b"><?= number_format($req['cost']) ?></td>
                <td class="py-2 px-4 border-b capitalize"><?= htmlspecialchars($req['status']) ?></td>
                <td class="py-2 px-4 border-b"><?= date('F j, Y H:i', strtotime($req['requested_at'])) ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php else: ?>
        <p>No training requests made yet.</p>
      <?php endif; ?>
    </section>
  </main>
</body>

</html>
