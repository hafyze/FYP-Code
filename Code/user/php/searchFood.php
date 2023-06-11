<?php

include("../php/dataconnection.php");

// Check if the search term is provided in the query parameters
if (isset($_GET['term'])) {
    $searchTerm = $_GET['term'];

    // Perform your search logic here
    $sql = "SELECT * FROM Food WHERE name LIKE '%searchTerm'";

    $result = $connection->query($sql);

    if ($result) {
        // Display the search results
        if ($result->num_rows > 0) {
            echo "<ul>";
            while ($row = $result->fetch_assoc()) {
                // Access individual rows and columns
                $foodName = $row['name'];
                // Generate HTML content for each search result
                echo "<li>$foodName</li>";
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