<?php
include("../php/dataconnection.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_name = $_POST["customer_name"];
    $customer_contact = $_POST["customer_contact"];
    $customer_email = $_POST["customer_email"];
    $customer_pass = $_POST["customer_pass"];
    $confirm_pass = $_POST["confirm_password"];

    // Password comparison
    if ($customer_pass !== $confirm_pass) {
        $error_message = "Error: Passwords do not match.";
        echo "<script>alert('$error_message');</script>"; // Error popup
    } else {
        // Email validation
        if (!filter_var($customer_email, FILTER_VALIDATE_EMAIL)) {
            $error_message = "Error: Invalid email format.";
            echo "<script>alert('$error_message');</script>"; // Error popup
        } else {
            // Phone number validation
            if (!preg_match("/^01[0-9]-[0-9]{7,8}$/", $customer_contact)) {
                $error_message = "Error: Invalid phone number format. Use format 01x-xxxxxxx.";
                echo "<script>alert('$error_message');</script>"; // Error popup
            } else {
                // Check for existing email
                $email_check_query = "SELECT * FROM customer WHERE customer_email='$customer_email' LIMIT 1";
                $email_result = $connection->query($email_check_query);
                if ($email_result->num_rows > 0) {
                    $error_message = "Error: Email already registered.";
                    echo "<script>alert('$error_message'); window.location.href = '../html/register.html';</script>"; // Error popup
                } else {
                    $sql = "INSERT INTO customer (customer_name, customer_contact, customer_email, customer_pass) 
                            VALUES ('$customer_name', '$customer_contact', '$customer_email', '$customer_pass')";

                if ($connection->query($sql) === TRUE) {
                    // Get the newly inserted customer ID
                    $customer_id = $connection->insert_id;
                    
                    // Start the session
                    session_start();
                    
                    // Store the customer ID in the session variable
                    $_SESSION['customer_id'] = $customer_id;
                    
                    // Redirect to the desired page
                    header("Location: ../html/index.html");
                    exit; // Exit after redirection
                } else {
                        echo "Error: " . $sql . "<br>";
                    }
                }
            }
        }
    }
}
?>
