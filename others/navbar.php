<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Navbar</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

<!-- Navbar -->
<nav class="bg-indigo-600 p-4">
    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
        <div class="relative flex items-center justify-between h-16">
            <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                <!-- Mobile menu button-->
                <button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-gray-700 hover:bg-indigo-500 focus:outline-none focus:bg-indigo-700 focus:text-white" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <!-- Icon when menu is closed -->
                    <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <!-- Icon when menu is open -->
                    <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="flex-1 flex items-center justify-center sm:items-stretch sm:justify-start">
                <div class="flex-shrink-0 text-white font-bold text-xl">
                    My Website
                </div>
                <div class="hidden sm:block sm:ml-6">
                    <div class="flex space-x-4">
                        <a href="#" class="text-white hover:bg-indigo-500 hover:text-white px-3 py-2 rounded-md text-lg font-medium">Home</a>
                        <a href="#" class="text-white hover:bg-indigo-500 hover:text-white px-3 py-2 rounded-md text-lg font-medium">About</a>
                        <a href="#" class="text-white hover:bg-indigo-500 hover:text-white px-3 py-2 rounded-md text-lg font-medium">Contact</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- Mobile Menu (Hidden by default) -->
<div class="sm:hidden" id="mobile-menu">
    <div class="px-2 pt-2 pb-3 space-y-1">
        <a href="#" class="text-white block px-3 py-2 rounded-md text-base font-medium">Home</a>
        <a href="#" class="text-white block px-3 py-2 rounded-md text-base font-medium">About</a>
        <a href="#" class="text-white block px-3 py-2 rounded-md text-base font-medium">Contact</a>
    </div>
</div>

<!-- Add TailwindJS script for toggling mobile menu -->
<script>
    const menuButton = document.querySelector('button');
    const mobileMenu = document.getElementById('mobile-menu');
    menuButton.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });
</script>

</body>
</html>
