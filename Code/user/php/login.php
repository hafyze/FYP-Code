<?php
// Establish database connection

include("../php/dataconnection.php");


// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve login form data
    $customer_email = $_POST["customer_email"];
    $customer_pass = $_POST["customer_pass"];

    // Insert user into the database
    $sql = "SELECT * FROM users
            WHERE customer_email = '$customer_email' AND customer_pass = '$customer_pass'";
    
    $result = $connection->query($sql);

    if ($result-> num_rows > 0) {
        $_SESSION["customer_email"] = $customer_email;
        echo "Login successful!";
    } else {
        echo "Invalid username or password";
    }
}

// Close database connection
$connection->close();
?>