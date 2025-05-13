<?php
require_once 'config.php';
session_start();

// Generate CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Fetch menu items
$stmt = $pdo->query("SELECT * FROM menu_items WHERE date = CURDATE() OR date IS NULL");
$menu_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch available time slots
$stmt = $pdo->query("SELECT slot_time FROM time_slots WHERE is_available = TRUE ORDER BY slot_time");
$time_slots = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $phone = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);
    $delivery_type = $_POST['delivery_type'];
    $time_slot = $_POST['time_slot'];
    $items = json_encode($_POST['items'] ?? []);
    $total = floatval($_POST['total']);

    $stmt = $pdo->prepare("INSERT INTO orders (customer_name, customer_phone, items, total, delivery_type, time_slot) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$name, $phone, $items, $total, $delivery_type, $time_slot]);

    echo "<script>alert('Order placed successfully!'); window.location.href='/order.php';</script>";
}
?>

<?php require_once 'header.php'; ?>

<section class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold mb-8 text-center">Place Your Order</h1>
        <form method="POST" class="max-w-lg mx-auto">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1" for="name">Name</label>
                <input type="text" id="name" name="name" class="w-full border rounded-md p-2" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1" for="phone">Phone</label>
                <input type="tel" id="phone" name="phone" class="w-full border rounded-md p-2" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Order Type</label>
                <select name="delivery_type" class="w-full border rounded-md p-2" required>
                    <option value="delivery">Delivery</option>
                    <option value="pickup">Pickup</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Time Slot</label>
                <select name="time_slot" class="w-full border rounded-md p-2" required>
                    <?php foreach ($time_slots as $slot): ?>
                        <option value="<?php echo htmlspecialchars($slot['slot_time']); ?>">
                            <?php echo date('h:i A', strtotime($slot['slot_time'])); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Select Items</label>
                <?php foreach ($menu_items as $item): ?>
                    <div class="flex items-center mb-2">
                        <input type="checkbox" name="items[<?php echo $item['id']; ?>][id]" value="<?php echo $item['id']; ?>" class="mr-2 item-checkbox" data-price="<?php echo $item['price']; ?>">
                        <label><?php echo htmlspecialchars($item['name']); ?> - $<?php echo number_format($item['price'], 2); ?></label>
                        <input type="number" name="items[<?php echo $item['id']; ?>][quantity]" min="0" value="0" class="w-16 ml-2 border rounded-md p-1 quantity" disabled>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Total</label>
                <input type="text" id="total" name="total" class="w-full border rounded-md p-2" readonly value="0.00">
            </div>
            <button type="submit" class="bg-yellow-400 text-black px-6 py-3 rounded-md hover:bg-yellow-500 w-full">Place Order</button>
        </form>
    </div>
</section>

<script src="scripts.js"></script>
<?php require_once 'footer.php'; ?>