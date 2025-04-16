<?php
session_start();
require_once('database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $payment = $_POST['payment'];
    $total = $_POST['total'];
    $user_id = $_SESSION['user_id'] ?? null; // Optional if you have login

    $cart = $_SESSION['cart'] ?? [];

    if (empty($cart)) {
        echo "Cart is empty.";
        exit();
    }

    try {
        $pdo->beginTransaction();

        // Insert into orders
        $stmt = $pdo->prepare("INSERT INTO orders (user_id, total, status) VALUES (?, ?, 'Pending')");
        $stmt->execute([$user_id, $total]);
        $order_id = $pdo->lastInsertId();

        // Insert order items
        $stmt = $pdo->prepare("INSERT INTO order_items (order_id, menu_id, quantity, price) VALUES (?, ?, ?, ?)");
        foreach ($cart as $item) {
            $stmt->execute([$order_id, $item['id'], $item['quantity'], $item['price']]);
        }

        $pdo->commit();
        unset($_SESSION['cart']);
        echo "<script>alert('Order placed successfully!');window.location.href='index.php';</script>";

    } catch (Exception $e) {
        $pdo->rollBack();
        echo "Error placing order: " . $e->getMessage();
    }
}
?>
