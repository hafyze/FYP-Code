<!DOCTYPE html>
<head>
    <title>Temp de Ventre</title>

    <script src="https://kit.fontawesome.com/fd65af94cc.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- Faster Time for CSS to take effect in debugging Style in page -->
    <link rel="stylesheet" href="../css/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../css/cart.css?v=<?php echo time(); ?>">
</head>
<body>
    <h1><a href="../html/index.html">Temp De Ventre</a></h1>
</body>

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