<?php
require '../backend/database.php';

if (!isset($_GET['id'])) {
    die("Student ID not provided.");
}

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
$stmt->execute([$id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$student) {
    die("Student not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Student</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded shadow-lg w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Edit Student</h2>
        <form action="../backend/edithandler.php" method="POST" class="space-y-4">
            <input type="hidden" name="id" value="<?= $student['id'] ?>">
            <div>
                <label class="block mb-1 font-semibold">Name</label>
                <input type="text" name="name" value="<?= htmlspecialchars($student['name']) ?>" required class="w-full border px-3 py-2 rounded">
            </div>
            <div>
                <label class="block mb-1 font-semibold">Age</label>
                <input type="number" name="age" value="<?= $student['age'] ?>" required class="w-full border px-3 py-2 rounded">
            </div>
            <div>
                <label class="block mb-1 font-semibold">Sex</label>
                <select name="sex" required class="w-full border px-3 py-2 rounded">
                    <option value="">-- Select --</option>
                    <option value="Male" <?= $student['sex'] === 'Male' ? 'selected' : '' ?>>Male</option>
                    <option value="Female" <?= $student['sex'] === 'Female' ? 'selected' : '' ?>>Female</option>
                    <option value="Other" <?= $student['sex'] === 'Other' ? 'selected' : '' ?>>Other</option>
                </select>
            </div>
            <div>
                <label class="block mb-1 font-semibold">Course</label>
                <input type="text" name="course" value="<?= htmlspecialchars($student['course']) ?>" required class="w-full border px-3 py-2 rounded">
            </div>
            <div>
                <label class="block mb-1 font-semibold">Registration Number</label>
                <input type="text" name="reg_no" value="<?= htmlspecialchars($student['reg_no']) ?>" required class="w-full border px-3 py-2 rounded">
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">
                Update Student
            </button>
        </form>
        <div class="mt-4 text-center">
            <a href="view.php" class="text-blue-500 hover:underline">← Back to Student List</a>
        </div>
    </div>
</body>
</html>
