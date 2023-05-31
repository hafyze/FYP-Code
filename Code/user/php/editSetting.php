<?php
session_start();
// Check if the user is logged in, otherwise redirect to the login page
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit;
}

// Include your database connection file
include('../php/dataconnection.php');

// Retrieve the user's profile information from the database
$custID = $_SESSION['customer_id'];
$query = "SELECT * FROM customer WHERE customer_id = $custID";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($result);

// Process the form submission for updating the profile
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $custName = $_POST['customer_name'];
    $custContact = $_POST['customer_contact'];
    $custEmail = $_POST['customer_email'];
    $custPassword = $_POST['customer_password'];

    // Update the user's profile in the database
    $updateCustSetting = "UPDATE users 
    SET customer_name = '$custName', customer_contact = '$custContact', customer_email = '$custEmail', customer_password = '$custPassword' 
    WHERE id = $custID";
    mysqli_query($connection, $updateCustSetting);

    // Redirect to the profile page after updating the profile
    header("Location: ../html/index.html");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Profile</title>
</head>
<body>
    <h1>User Profile</h1>
    <form action="" method="POST">
        <label for="customer_name">Name:</label>
        <input type="text" id="customer_name" name="customer_name" value="<?php echo isset($_POST['customer_name']) ? $_POST['customer_name'] : $row['customer_name']; ?>"><br>

        <label for="customer_contact">Contact:</label>
        <input type="text" id="customer_contact" name="customer_contact" value="<?php echo isset($_POST['customer_contact']) ? $_POST['customer_contact'] : $row['customer_contact']; ?>"><br>

        <label for="customer_email">Email:</label>
        <input type="email" id="customer_email" name="customer_email" value="<?php echo isset($_POST['customer_email']) ? $_POST['customer_email'] : $row['customer_email']; ?>"><br>

        <label for="customer_password">Password:</label>
        <input type="password" id="customer_password" name="customer_password" value="<?php echo isset($_POST['customer_password']) ? $_POST['customer_password'] : $row['customer_password']; ?>"><br>

        <input type="submit" value="Update Profile">
    </form>
</body>
</html>