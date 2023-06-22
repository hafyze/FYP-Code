<?php
// Create a new MySQLi instance
include("../php/dataconnection.php");

// Fetch the unique product types/categories from the product table
$query = "SELECT DISTINCT product_type FROM product";
$result = $connection->query($query);

if ($result->num_rows > 0) {
    // Loop through each category
    while ($row = $result->fetch_assoc()) {
        $category = $row['product_type'];

        // Fetch the food items for the current category
        $foodQuery = "SELECT * FROM product WHERE product_type = '$category'";
        $foodResult = $connection->query($foodQuery);

        if ($foodResult->num_rows > 0) {
            // Display the category and food items
            echo "<h3>$category</h3>";
            echo "<ul>";

            while ($foodRow = $foodResult->fetch_assoc()) {
                $foodId = $foodRow['product_id'];
                $foodName = $foodRow['product_name'];
                $foodPrice = $foodRow['price'];

                // Generate HTML content for each food item
                echo "<li>$foodName - RM$foodPrice";
                echo "<form class='add-to-cart-form' action='../php/addCart.php' method='POST'>";
                echo "<input type='hidden' name='product_id' value='$foodId'>";
                echo "<input type='hidden' name='product_name' value='$foodName'>";
                echo "<input type='hidden' name='product_price' value='$foodPrice'>";
                echo "<button type='submit'>Add to Cart</button>";
                echo "</form>";
                echo "</li>";
            }

            echo "</ul>";
        }
    }
} else {
    echo "No food items found.";
}

// Close the database connection
$connection->close();
?>
