<?php
// Establish database connection
include("../php/dataconnection.php");

// Process product addition to cart
if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
    session_start();

    if (!isset($_SESSION['customer_id'])) {
        header("Location: ../php/login.php");
        exit;
    }

    $productID = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $customerID = $_SESSION['customer_id'];

    // Prepare the SQL statement to insert into the cart table
    $sql = "INSERT INTO cart (customer_id, product_id, quantity) 
            VALUES ('$customerID', '$productID', '$quantity')";

    if ($connection->query($sql) === true) {
        // Display success message
        echo "<p>Product added to cart successfully.</p>";
        header("Location: ../php/cart.php");
    } else {
        // Display error message
        echo "<p>Error adding product to cart: " . $connection->error . "</p>";
    }
}

// Close the database connection
$connection->close();
?>
