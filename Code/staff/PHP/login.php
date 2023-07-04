<?php
session_start();

include("../php/dataconnection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $staff_id = $_POST["staff_id"];
    $staff_pass = $_POST["staff_pass"];

    // Prepare and execute the query
    $sql = "SELECT * FROM staff WHERE staff_id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $staff_id);
    $stmt->execute();

    // Store the result in a variable
    $result = $stmt->get_result();

    // Check if email exists in the db
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $storedPassword = $row['staff_pass']; // Assuming the password column is named "staff_pass"
        header("Location:../php/googledash.php ");

    } else {
        $errorMessage = "Invalid email";
        echo "<script>alert('Invalid id or password'); window.location.href = '../html/login.html';</script>";
    }
}
?>
