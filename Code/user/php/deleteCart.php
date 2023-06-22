<?php
session_start();

if (isset($_GET['index'])) {
    $index = $_GET['index'];

    if (isset($_SESSION['cart'][$index])) {
        unset($_SESSION['cart'][$index]); // Remove the item from the cart array
    }

    // Redirect the user back to the cart page or any other desired page
    header('Location: ../php/cart.php');
    exit();
}
?>
