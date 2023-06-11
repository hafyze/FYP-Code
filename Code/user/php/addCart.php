<?php

// Start the session if not already started
session_start();

if (isset($_POST['product'])) {
    $product = $_POST['product'];

    // Check if the cart array exists in the session
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array(); // Create an empty cart array
    }

    // Add the selected product to the cart
    $item = array('product' => $product);
    $_SESSION['cart'][] = $item;

    // Redirect the user back to the search results page or any other desired page
    header('Location: ../php/cart.php');
    exit();
}

?>