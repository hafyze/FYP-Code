<?php
session_start();

include("../php/dataconnection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Data from form is declared 
    $customer_name = $_POST["customer_name"];
    $customer_contact = $_POST["customer_contact"];
    $customer_email = $_POST["customer_email"];
    $customer_pass = $_POST["customer_pass"];

    // Insert user into the database
    $sql = "INSERT INTO customer (customer_name, customer_contact, customer_email, customer_pass) 
        VALUES ('$customer_name', '$customer_contact', '$customer_email', '$customer_pass')";

    if ($connection->query($sql) === TRUE) {
        header("Location: ../html/index.html");
    } else {
        echo "Error: " . $sql . "<br>";
    }
}

$connection->close();
?>