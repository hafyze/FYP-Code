<?php
session_start();

if (isset($_POST['quantity'])) {
    $newQuantities = $_POST['quantity'];

    if (isset($_SESSION['cart'])) {
        $cartItems = $_SESSION['cart'];

        foreach ($newQuantities as $key => $newQuantity) {
            if (isset($cartItems[$key]) && is_array($cartItems[$key]) && isset($cartItems[$key]['product'])) {
                $cartItems[$key]['quantity'] = $newQuantity;
            }
        }

        $_SESSION['cart'] = $cartItems;

        // Redirect the user back to the cart page or any other desired page
        header('Location: ../php/cart.php');
        exit();
    }
}
?>
