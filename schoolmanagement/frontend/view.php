<?php
require '../backend/database.php';

// Fetch all students
$stmt = $pdo->query("SELECT * FROM students ORDER BY id DESC");
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Students</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen py-10">
    <div class="max-w-5xl mx-auto bg-white p-6 rounded shadow-lg">
        <h2 class="text-3xl font-bold mb-6 text-center">Student List</h2>
        <?php if (isset($_GET['message']) && $_GET['message'] === 'success'): ?>
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                Student added successfully!
            </div>
        <?php endif; ?>

        <table class="w-full table-auto border-collapse">
            <thead>
                <tr class="bg-gray-200 text-left">
                    <th class="border p-2">#</th>
                    <th class="border p-2">Name</th>
                    <th class="border p-2">Age</th>
                    <th class="border p-2">Sex</th>
                    <th class="border p-2">Course</th>
                    <th class="border p-2">Reg. No</th>
                    <th class="border p-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($students): ?>
                    <?php foreach ($students as $i => $student): ?>
                        <tr>
                            <td class="border p-2"><?= $i + 1 ?></td>
                            <td class="border p-2"><?= htmlspecialchars($student['name']) ?></td>
                            <td class="border p-2"><?= $student['age'] ?></td>
                            <td class="border p-2"><?= $student['sex'] ?></td>
                            <td class="border p-2"><?= htmlspecialchars($student['course']) ?></td>
                            <td class="border p-2"><?= htmlspecialchars($student['reg_no']) ?></td>
                            <td class="border p-2 space-x-2">
                                <a href="edit.php?id=<?= $student['id'] ?>" class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500">Edit</a>
                                <a href="../backend/deletehandler.php?id=<?= $student['id'] ?>" onclick="return confirm('Are you sure?');" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center p-4">No students found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="mt-6 text-center">
            <a href="index.php" class="text-blue-500 hover:underline">← Back to Home</a>
        </div>
    </div>
</body>
</html>
