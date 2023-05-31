<?php
session_start();
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit;
}

include('../php/dataconnection.php');

// get user profile info from the db
$custId = $_SESSION['customer_id'];
$query = "SELECT * FROM users WHERE id = $custId";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($result);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $custName = $_POST['customer_name'];
    $custContact = $_POST['customer_contact'];
    $custEmail = $_POST['customer_email'];
    $custPassword = $_POST['customer_password'];

    // Update the user's profile in the database
    $updateQuery = "UPDATE users 
    SET customer_name = '$custName', customer_contact = '$custContact', customer_email = '$custEmail', customer_password = '$custPassword' 
    WHERE id = $userID";

    mysqli_query($connection, $updateQuery);

    header("Location: profile.php");
    exit;
}
?>