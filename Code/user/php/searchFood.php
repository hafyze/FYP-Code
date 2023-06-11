<?php
session_start();

include("../php/dataconnection.php");


// Check if the search term is provided in the query parameters
if (isset($_GET['foodSearch'])) {
    $searchTerm = $_GET['foodSearch'];

    // Perform your search logic here
    $sql = "SELECT * FROM product WHERE product_name LIKE '%$searchTerm%'";

    $result = $connection->query($sql);

    if ($result) {
        // Display the search results
        if ($result->num_rows > 0) {
            echo "<ul>";
            while ($row = $result->fetch_assoc()) {
                $foodName = $row['product_name'];
                $foodPrice = $row['price'];
                // Generate HTML content for each search result with "Add to Cart" form
                echo "<li>$foodName RM$foodPrice";
                echo "<form class='add-to-cart-form' action='../php/addCart.php' method='POST'>";
                echo "<input type='hidden' name='product' value='$foodName'>";
                echo "<button type='submit'>Add to Cart</button>";
                echo "</form>";
                echo "</li>";
            }
            echo "</ul>";
        } else {
            echo "No results found.";
        }
    } 
}

// Close the database connection
$connection->close();
?>