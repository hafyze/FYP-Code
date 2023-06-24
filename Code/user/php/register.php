<?php
session_start();

include("../php/dataconnection.php");


$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_name = $_POST["customer_name"];
    $customer_contact = $_POST["customer_contact"];
    $customer_email = $_POST["customer_email"];
    $customer_pass = $_POST["customer_pass"];
    $confirm_pass = $_POST["confirm_password"];

    // password comparison
    if ($customer_pass !== $confirm_pass) {
        $error_message = "Error: Passwords do not match.";
        echo "<script>alert('$error_message');</script>"; // Error popup
    } 
    else {
        // check for existing email
        $email_check_query = "SELECT * FROM customer WHERE customer_email='$customer_email' LIMIT 1";
        $email_result = $connection->query($email_check_query);
        if ($email_result->num_rows > 0) {
            $error_message = "Error: Email already registered.";
            echo "<script>alert('$error_message');</script>"; // Error popup
        } 
        else {
            $sql = "INSERT INTO customer (customer_name, customer_contact, customer_email, customer_pass) 
                    VALUES ('$customer_name', '$customer_contact', '$customer_email', '$customer_pass')";

            if ($connection->query($sql) === TRUE) {
                header("Location: ../html/index.html");
            } else {
                echo "Error: " . $sql . "<br>";
            }
        }
    }
}

$connection->close();
?>