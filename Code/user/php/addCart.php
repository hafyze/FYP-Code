<?php
session_start();

if (isset($_POST['product'])) {
    $selectedProduct = $_POST['product'];

    // Store the selected product in the user's cart or session
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }
    $_SESSION['cart'][] = $selectedProduct;

    // Redirect back to the search page or show a success message
    header("Location: index.html");
    exit();
} else {
    echo "Invalid request.";
}
?>
