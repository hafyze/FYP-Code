<?php
    include("../php/dataconnection.php");

    // Retrieve the promotion data from the promotion table
    $sql = "SELECT * FROM promotion";
    $result = $connection->query($sql);

    // Convert the promotion data into an associative array
    $promotionData = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $promotionData[] = $row;
        }
    }

    // Set the response content type to JSON
    header('Content-Type: application/json');

    // Output the promotion data as JSON
    echo json_encode($promotionData);
?>
