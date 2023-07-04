<?php
session_start();
// Establish database connection
include("../php/dataconnection.php");


// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve login form data
    $admin_id = $_POST["admin_id"];
    $admin_pass = $_POST["admin_pass"];

    // Check customer from DB
    $sql = "SELECT * FROM admin
            WHERE admin_id = '$admin_id' AND admin_pass = '$admin_pass'";
    
    $result = $connection->query($sql);

    //Checks if customer is available from DB
    if ($result-> num_rows > 0) {
        $_SESSION["admin_id"] = $admin_id;
        echo "Login successful!";
        //Redirect to index.html
        header("Location: ../php/Adminindex.php");
    } else {
        echo "Invalid id or password";
    }
}

// Close database connection
$connection->close();
?>