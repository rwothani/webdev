<!-- cart.php -->
<?php
session_start();
require_once('database.php');

// Sample structure for $_SESSION['cart']:
/*
$_SESSION['cart'] = [
  ['id' => 1, 'name' => 'Burger', 'price' => 5.99, 'quantity' => 2],
  ['id' => 2, 'name' => 'Fries', 'price' => 2.99, 'quantity' => 1]
];
*/

$cart = $_SESSION['cart'] ?? [];
$total = 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Your Cart</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-amber-50">
    <nav class="bg-orange-500 text-white p-12 shadow-md flex justify-between items-center">
        <h1 class="text-2xl font-bold">🍔 Fast Bites</h1>
        <ul class="flex space-x-6 font-medium">
            <li><a href="index.php" class="hover:text-black">Home</a></li>
            <li><a href="menu.php" class="hover:text-black">Menu</a></li>
            <li><a href="cart.php" class="hover:text-black">Cart</a></li>
            
            <li><a href="contact.php" class="hover:text-black">Contact</a></li>
            <?php if (isset($_SESSION['user_id'])): ?>
            <a href="logout.php" class="hover:text-black">Logout</a>
            <?php else: ?>
            <a href="login.php" class="hover:text-black">Login</a>
            <?php endif; ?>
        </ul>
    </nav>

    <section class="px-6 md:px-20 py-12">
        <h2 class="text-3xl font-bold text-orange-600 mb-8">🛒 Your Cart</h2>

        <?php if (count($cart) > 0): ?>
        <div class="space-y-6">
            <?php foreach ($cart as $index => $item): 
          $item_total = $item['price'] * $item['quantity'];
          $total += $item_total;
        ?>
            <div class="bg-white rounded-xl shadow-md p-5 flex justify-between items-center">
                <div>
                    <h3 class="text-xl font-semibold text-brown-700"><?= htmlspecialchars($item['name']) ?></h3>
                    <p class="text-sm text-gray-600">Price: $<?= number_format($item['price'], 2) ?> ×
                        <?= $item['quantity'] ?></p>
                </div>
                <form method="POST" action="update_cart.php" class="flex items-center gap-3">
                    <input type="hidden" name="index" value="<?= $index ?>">
                    <input type="number" name="quantity" min="1" value="<?= $item['quantity'] ?>"
                        class="w-16 border px-2 py-1 rounded" />
                    <button type="submit"
                        class="bg-orange-500 text-white px-4 py-1 rounded hover:bg-orange-600">Update</button>
                    <a href="remove_item.php?index=<?= $index ?>" class="text-red-600 hover:underline">Remove</a>
                </form>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="text-right mt-6">
            <p class="text-xl font-bold text-orange-700">Total: $<?= number_format($total, 2) ?></p>
            <a href="checkout.php"
                class="mt-4 inline-block bg-black text-white px-6 py-2 rounded hover:bg-gray-800">Proceed to
                Checkout</a>
        </div>

        <?php else: ?>
        <p class="text-gray-600">Your cart is empty.</p>
        <?php endif; ?>
    </section>

</body>

</html>