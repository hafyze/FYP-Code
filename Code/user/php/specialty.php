<?php
// Create a new MySQLi instance
include("../php/dataconnection.php");

// Fetch the unique product types/categories from the product table
$query = "SELECT DISTINCT product_type FROM product";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    // Loop through each category
    while ($row = $result->fetch_assoc()) {
        $category = $row['product_type'];

        // Fetch the food items for the current category
        $foodQuery = "SELECT * FROM product WHERE product_type = '$category'";
        $foodResult = $conn->query($foodQuery);

        if ($foodResult->num_rows > 0) {
            // Display the category and food items
            echo "<h3>$category</h3>";
            echo "<ul>";

            while ($foodRow = $foodResult->fetch_assoc()) {
                $foodName = $foodRow['product_name'];
                $foodPrice = $foodRow['product_price'];

                // Generate HTML content for each food item
                echo "<li>$foodName - RM$foodPrice</li>";
            }

            echo "</ul>";
        }
    }
} else {
    echo "No food items found.";
}

// Close the database connection
$conn->close();
?>
