<?php

include("../php/dataconnection.php");

// Handle quantity update and item removal
if (isset($_POST['order_id'])) {
    $orderID = $_POST['order_id'];
    $action = $_POST['action'];

    if ($action === 'update') {
        $quantity = $_POST['quantity'];

        // Prepare the SQL statement to update the quantity
        $sql = "UPDATE food_order SET quantity = '$quantity' WHERE order_id = '$orderID'";

        if ($connection->query($sql) === true) {
            // Display success message
            echo "<p>Quantity updated successfully.</p>";
        } else {
            // Display error message
            echo "<p>Error updating quantity: " . $connection->error . "</p>";
        }
    } elseif ($action === 'remove') {
        // Prepare the SQL statement to delete the item from the cart
        $sql = "DELETE FROM food_order WHERE order_id = '$orderID'";

        if ($connection->query($sql) === true) {
            // Display success message
            echo "<p>Item removed from cart successfully.</p>";
        } else {
            // Display error message
            echo "<p>Error removing item from cart: " . $connection->error . "</p>";
        }
    }
}

// Retrieve and display items in the cart
$sql = "SELECT * FROM food_order INNER JOIN product ON food_order.product_id = product.product_id";
$result = $connection->query($sql);

if ($result->num_rows > 0) {
    echo "<h2>Cart Items:</h2>";

    while ($row = $result->fetch_assoc()) {
        $orderID = $row['order_id'];
        $productName = $row['product_name'];
        $quantity = isset($row['quantity']) ? $row['quantity'] : null;
    
        echo "<p>Product Name: $productName</p>";
    
        if ($quantity !== null) {
            echo "<p>Quantity: $quantity</p>";
    
            // Update quantity form
            echo '<form action="" method="POST">';
            echo '<input type="hidden" name="order_id" value="' . $orderID . '">';
            echo '<input type="hidden" name="action" value="update">';
            echo '<label for="quantity">Update Quantity:</label>';
            echo '<input type="number" name="quantity" value="' . $quantity . '" min="1" required>';
            echo '<button type="submit">Update</button>';
            echo '</form>';
        } else {
            echo "<p>Quantity: Not available</p>";
        }
    
        // Remove item form
        echo '<form action="" method="POST">';
        echo '<input type="hidden" name="order_id" value="' . $orderID . '">';
        echo '<input type="hidden" name="action" value="remove">';
        echo '<button type="submit">Remove</button>';
        echo '</form>';
    
        echo "<hr>";
    }
    

} else {
    echo "<p>Cart is empty.</p>";
}

// Close the database connection
$connection->close();
?>
