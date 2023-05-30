<?php
// Establish database connection

include("../dataconnection.php");


// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve login form data
    $staff_email = $_POST["staff_email"];
    $staff_pass = $_POST["staff_pass"];

    // Check customer from DB
    $sql = "SELECT * FROM staff
            WHERE staff_email = '$staff_email' AND staff_pass = '$staff_pass'";
    
    $result = $connection->query($sql);

    //Checks if customer is available from DB
    if ($result-> num_rows > 0) {
        $_SESSION["staff_email"] = $staff_email;
        echo "Login successful!";
        //Redirect to index.html
        header("Location: ../index.html");
    } else {
        echo "Invalid username or password";
    }
}

// Close database connection
$connection->close();
?>