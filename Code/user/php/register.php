<?php
// Establish database connection

include("../php/dataconnection.php");

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $customer_name = $_POST["customer_name"];
    $customer_contact = $_POST["customer_contact"];
    $customer_email = $_POST["customer_email"];
    $customer_pass = $_POST["customer_pass"];

    // Insert user into the database
    $sql = "INSERT INTO customer (customer_name, customer_contact, customer_email, customer_pass) 
            VALUES ('$customer_name', '$customer_contact', '$customer_email', $customer_pass)";
    
    if ($connection->query($sql) === TRUE) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $sql . "<br>" . $connection->error;
    }
}

// Close database connection
$connection->close();
?>