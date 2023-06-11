<?php
session_start();

if (isset($_SESSION['cart'])) {
    $cartItems = $_SESSION['cart'];

    if (!empty($cartItems)) {
        foreach ($cartItems as $item) {
            if (is_array($item) && isset($item['product'])) {
                $productName = $item['product'];
                echo "<li>$productName</li>";
            }
        }
    } else {
        echo "<li>Cart is empty</li>";
    }
} else {
    echo "<li>Cart is empty</li>";
}
?>