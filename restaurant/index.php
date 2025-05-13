<?php
require_once 'config.php';
$stmt = $pdo->query("SELECT * FROM menu_items WHERE date = CURDATE() OR date IS NULL LIMIT 3");
$featured = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php require_once 'header.php'; ?>

<!-- Hero Section -->
<section class="relative bg-cover bg-center h-96" style="background-image: url('/assets/images/hero.jpg')">
    <div class="absolute inset-0 bg-black opacity-50"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-center">
        <div class="text-center text-white">
            <h1 class="text-4xl sm:text-5xl font-bold mb-4">Welcome to Palace Restaurant</h1>
            <p class="text-xl mb-6">Savor authentic local and global flavors in a warm, inviting setting.</p>
            <div class="space-x-4">
                <a href="order.php" class="bg-yellow-400 text-black px-6 py-3 rounded-md hover:bg-yellow-500">Order Now</a>
                <a href="order.php#booking" class="border border-yellow-400 text-yellow-400 px-6 py-3 rounded-md hover:bg-yellow-400 hover:text-black">Book a Table</a>
            </div>
        </div>
    </div>
</section>

<!-- Featured Dishes -->
<section class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold mb-8 text-center">Featured Dishes</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($featured as $dish): ?>
                <div class="bg-white shadow-md rounded-md overflow-hidden">
                    <img src="<?php echo htmlspecialchars($dish['image']); ?>" alt="<?php echo htmlspecialchars($dish['name']); ?>" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="text-xl font-semibold"><?php echo htmlspecialchars($dish['name']); ?></h3>
                        <p class="text-gray-600 mt-2"><?php echo htmlspecialchars($dish['description']); ?></p>
                        <p class="text-yellow-400 font-bold mt-2">$<?php echo number_format($dish['price'], 2); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- About Preview -->
<section class="bg-yellow-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold mb-4">Our Story</h2>
        <p class="text-lg mb-6">Palace Restaurant blends tradition with innovation, offering a curated menu of local and international dishes. Our passion for quality ingredients and exceptional service creates unforgettable dining experiences.</p>
        <a href="about.php" class="bg-yellow-400 text-black px-6 py-3 rounded-md hover:bg-yellow-500">Learn More</a>
    </div>
</section>

<?php require_once 'footer.php'; ?>