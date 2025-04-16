<!-- checkout.php -->
<?php
session_start();
require_once('database.php');

$cart = $_SESSION['cart'] ?? [];
$total = 0;
foreach ($cart as $item) {
  $total += $item['price'] * $item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Checkout</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-amber-50">

  <section class="px-6 md:px-20 py-12 grid md:grid-cols-2 gap-12">
    <div>
      <h2 class="text-3xl font-bold text-orange-600 mb-6">🧾 Order Summary</h2>
      <ul class="space-y-4">
        <?php foreach ($cart as $item): ?>
          <li class="flex justify-between border-b pb-2">
            <span><?= htmlspecialchars($item['name']) ?> × <?= $item['quantity'] ?></span>
            <span>$<?= number_format($item['price'] * $item['quantity'], 2) ?></span>
          </li>
        <?php endforeach; ?>
        <li class="flex justify-between font-bold text-lg pt-4">
          <span>Total</span>
          <span>$<?= number_format($total, 2) ?></span>
        </li>
      </ul>
    </div>

    <form action="place_order.php" method="POST" class="bg-white p-8 shadow-lg rounded-xl space-y-5">
      <h2 class="text-2xl font-bold text-brown-800">Enter Delivery Info</h2>
      <input type="text" name="name" placeholder="Full Name" required class="w-full border p-3 rounded">
      <input type="text" name="address" placeholder="Delivery Address" required class="w-full border p-3 rounded">
      <select name="payment" class="w-full border p-3 rounded">
        <option value="Cash on Delivery">Cash on Delivery</option>
        <option value="Mobile Money">Mobile Money</option>
      </select>
      <input type="hidden" name="total" value="<?= $total ?>">
      <button type="submit" class="bg-orange-500 text-white px-6 py-2 rounded hover:bg-orange-600">Place Order</button>
    </form>
  </section>

</body>
</html>
