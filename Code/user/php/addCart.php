

<?php
// Establish database connection
include("../php/dataconnection.php");

// Process product addition to cart
if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $productID = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Prepare the SQL statement to insert into the food_order table
    $sql = "INSERT INTO food_order (order_status, product_id, order_type_id) 
            VALUES ('In Kitchen', '$productID', '1')";

    if ($connection->query($sql) === true) {
        $orderID = $connection->insert_id;
        // Display success message
        echo "<p>Product added to cart. Order ID: $orderID</p>";
    } else {
        // Display error message
        echo "<p>Error adding product to cart: " . $connection->error . "</p>";
    }
}

// Close the database connection
$connection->close();
?>