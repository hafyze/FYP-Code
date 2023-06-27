<?php
session_start();

include("../php/dataconnection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_email = $_POST["customer_email"];
    $customer_pass = $_POST["customer_pass"];

    // Prepare and execute the query
    $sql = "SELECT * FROM customer WHERE customer_email = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $customer_email);
    $stmt->execute();

    // Store the result in a variable
    $result = $stmt->get_result();

    // Check if email exists in the db
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $storedPassword = $row['customer_pass']; // Assuming the password column is named "customer_pass"

        // Verify the password
        if ($customer_pass == $storedPassword) {
            // Password matches, create a session
            $_SESSION["customer_id"] = $row['customer_id'];
            echo "Login successful!";
            // Redirect to main page or perform any other actions
            header("Location: ../html/index.html");
            exit;
        } else {
            $errorMessage = "Invalid password";
            echo "<script>alert('Invalid email or password');</script>";
        }
    } else {
        $errorMessage = "Invalid email";
        echo "<script>alert('Invalid email or password');</script>";
    }
}
?>
