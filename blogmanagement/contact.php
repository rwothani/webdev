<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Us</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

    <nav class="bg-white shadow p-4 flex justify-between">
        <h1 class="text-xl font-bold text-indigo-600">My Blog</h1>
        <div class="space-x-4">
            <a href="index.php" class="text-indigo-600 hover:underline">Home</a>
            <a href="about.php" class="text-indigo-600 hover:underline">About</a>
        </div>
    </nav>

    <main class="max-w-2xl mx-auto mt-10 bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-bold mb-6 text-indigo-700">Contact Us</h2>

        <form action="backend/contacthandler.php" method="POST" class="space-y-4">
            <div>
                <label class="block mb-1 font-semibold">Name</label>
                <input type="text" name="name" required
                       class="w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block mb-1 font-semibold">Email</label>
                <input type="email" name="email" required
                       class="w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block mb-1 font-semibold">Message</label>
                <textarea name="message" rows="6" required
                          class="w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
            </div>
            <div>
                <button type="submit"
                        class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Send Message</button>
            </div>
        </form>
    </main>

</body>
</html>
