<?php
// Include the database connection file
include("../php/dataconnection.php");

// Retrieve the delivery data from the database
$query = "SELECT * FROM delivery";
$result = mysqli_query($connection, $query);

// Check if there are any delivery records
if (mysqli_num_rows($result) > 0) {
    echo '<div class="container">';
    echo '<div class="row justify-content-center">';

    // Iterate through each delivery record and display the data
    while ($row = mysqli_fetch_assoc($result)) {
        $deliveryId = $row['delivery_id'];
        $fee = $row['fee'];
        $status = $row['delivery_status'];
        $address = $row['address'];

        echo '<div class="col-md-6">';
        echo '<div class="card mb-4">';
        echo '<div class="card-body">';
        echo "<h3 class='card-title'>Delivery ID: $deliveryId</h3>";
        echo "<p class='card-text'>Fee: $fee</p>";
        echo "<p class='card-text'>Status: $status</p>";
        echo "<p class='card-text'>Address: $address</p>";
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }

    echo '</div>';
    echo '</div>';
} else {
    // Display a message if no delivery records are found
    echo '<div class="container">';
    echo '<p>No delivery records found.</p>';
    echo '</div>';
}

// Close the database connection
mysqli_close($connection);
?>
