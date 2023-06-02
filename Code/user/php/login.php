<?php
// Establish database connection
session_start();

include("../php/dataconnection.php");


// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve login form data
    $customer_email = $_POST["customer_email"];
    $customer_pass = $_POST["customer_pass"];

    // Check customer from DB
    $sql = "SELECT * FROM customer
            WHERE customer_email = '$customer_email' AND customer_pass = '$customer_pass'";
    
    $result = $connection->query($sql);

    //Checks if customer is available from DB
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION["customer_id"] = $row['customer_id'];
        echo "Login successful!";
        //Redirect to index.html
        header("Location: ../html/index.html");
        exit;
    } else {
        echo "Invalid username or password";
    }
}
?>