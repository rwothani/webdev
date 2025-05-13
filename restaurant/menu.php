<?php
require_once 'config.php';
$stmt = $pdo->query("SELECT * FROM menu_items WHERE date = CURDATE() OR date IS NULL ORDER BY category, name");
$menu_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php require_once 'header.php'; ?>

<section class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold mb-8 text-center">Our Menu</h1>
        <div class="space-y-12">
            <?php
            $categories = ['local' => 'Local Delights', 'foreign' => 'Global Flavors', 'special' => 'Daily Specials'];
            foreach ($categories as $cat_key => $cat_name):
                $items = array_filter($menu_items, function($item) use ($cat_key) {
                    return $item['category'] === $cat_key;
                });
                if (count($items) > 0):
            ?>
                <div>
                    <h2 class="text-2xl font-semibold mb-4"><?php echo htmlspecialchars($cat_name); ?></h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php foreach ($items as $item): ?>
                            <div class="bg-white shadow-md rounded-md overflow-hidden">
                                <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" class="w-full h-48 object-cover">
                                <div class="p-4">
                                    <h3 class="text-xl font-semibold"><?php echo htmlspecialchars($item['name']); ?></h3>
                                    <p class="text-gray-600 mt-2"><?php echo htmlspecialchars($item['description']); ?></p>
                                    <p class="text-yellow-400 font-bold mt-2">$<?php echo number_format($item['price'], 2); ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; endforeach; ?>
        </div>
    </div>
</section>

<?php require_once 'footer.php'; ?>