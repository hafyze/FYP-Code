<?php
session_start();

if (isset($_SESSION['cart'])) {
    $cartItems = $_SESSION['cart'];

    if (!empty($cartItems)) {
        foreach ($cartItems as $key => $item) {
            if (is_array($item) && isset($item['product'])) {
                $productName = $item['product'];
                $quantity = $item['quantity'];
        
                echo "<li>$productName (Quantity: ";
                echo "<input type='number' name='quantity[$key]' value='$quantity' min='1'>";
                echo ")</li>";
                echo "<a href='../php/deleteCart.php?index=$key'>Delete</a>";
                echo "</li>";
            }
        }
        echo "<input type='submit' value='Update Quantity'>";
        echo "</form>";
    } else {
        echo "<li>Cart is empty</li>";
    }
} else {
    echo "<li>Cart is empty</li>";
}
?>