<?php
// Establish database connection
include("../php/dataconnection.php");

// Process user input
if (isset($_GET['keyword'])) {
    $keyword = $_GET['keyword'];

    // Prepare the SQL statement
    $sql = "SELECT * FROM product WHERE 
            product_type LIKE '%$keyword%' OR 
            product_name LIKE '%$keyword%' OR 
            product_ingredients LIKE '%$keyword%'";

    // Execute the query
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        // Display the search results
        echo "<h2>Search Results:</h2>";
        while ($row = $result->fetch_assoc()) {
            echo "<p>Product Type: " . $row['product_type'] . "</p>";
            echo "<p>Product Name: " . $row['product_name'] . "</p>";
            echo "<p>Product Ingredients: " . $row['product_ingredients'] . "</p>";
            echo "<p>Price: RM" . $row['price'] . "</p>";
            echo "<hr>";
        }
    } else {
        echo "<p>No results found.</p>";
    }

    // Close the database connection
    $connection->close();
}
?>

<!-- HTML form for the search feature -->
<form method="GET" action="">
    <input type="text" name="keyword" placeholder="Enter a keyword" required>
    <button type="submit">Search</button>
</form>
