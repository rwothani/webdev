<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $index = $_POST['index'];
    $quantity = max(1, intval($_POST['quantity'])); // Prevent zero or negative

    if (isset($_SESSION['cart'][$index])) {
        $_SESSION['cart'][$index]['quantity'] = $quantity;
    }
}

header("Location: cart.php");
exit();
?>
