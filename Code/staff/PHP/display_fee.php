<?php
// Assuming you have already established a database connection
include("../dataconnection.php");
// Retrieve staff name from the staff table
$query = "SELECT name FROM staff";
$result = mysqli_query($connection, $query);

// Store the staff names in an array
$staffNames = [];
while ($row = mysqli_fetch_assoc($result)) {
    $staffNames[] = $row['name'];
}

// Retrieve fee data from the delivery table
$query = "SELECT fee FROM delivery";
$result = mysqli_query($connection, $query);

// Store the fee data in an array
$fees = [];
while ($row = mysqli_fetch_assoc($result)) {
    $fees[] = $row['fee'];
}

// Close the database connection
mysqli_close($connection);

// Pass the staff names and fee data to the HTML template
include 'your_html_file.html';
?>

