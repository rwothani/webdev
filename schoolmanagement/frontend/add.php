<!-- add.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Student</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded shadow-lg w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Add Student</h2>
        <form action="../backend/formhandler.php" method="POST" class="space-y-4">
            <div>
                <label class="block mb-1 font-semibold">Name</label>
                <input type="text" name="name" required class="w-full border px-3 py-2 rounded">
            </div>
            <div>
                <label class="block mb-1 font-semibold">Age</label>
                <input type="number" name="age" required class="w-full border px-3 py-2 rounded">
            </div>
            <div>
                <label class="block mb-1 font-semibold">Sex</label>
                <select name="sex" required class="w-full border px-3 py-2 rounded">
                    <option value="">-- Select --</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    
                </select>
            </div>
            <div>
                <label class="block mb-1 font-semibold">Course</label>
                <input type="text" name="course" required class="w-full border px-3 py-2 rounded">
            </div>
            <div>
                <label class="block mb-1 font-semibold">Registration Number</label>
                <input type="text" name="reg_no" required class="w-full border px-3 py-2 rounded">
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">
                Submit
            </button>
        </form>
        <div class="mt-4 text-center">
            <a href="index.php" class="text-blue-500 hover:underline">Back to Home</a>
        </div>
    </div>
</body>
</html>
