<?php
session_start();
require_once('database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $menu_id = $_POST['menu_id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $cart = &$_SESSION['cart'];
    $found = false;

    foreach ($cart as &$item) {
        if ($item['id'] == $menu_id) {
            $item['quantity'] += $quantity;
            $found = true;
            break;
        }
    }

    if (!$found) {
        $cart[] = [
            'id' => $menu_id,
            'name' => $name,
            'price' => $price,
            'quantity' => $quantity
        ];
    }

    header("Location: cart.php");
    exit();
}
?>
