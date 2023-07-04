<!DOCTYPE html>
<html>

<head>
    <title>Temp de Ventre</title>

    <script src="https://kit.fontawesome.com/fd65af94cc.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- Faster Time for CSS to take effect in debugging Style in page -->
    <link rel="stylesheet" href="../css/style.css?v=<?php echo time(); ?>">

</head>

<body>
    <h1>Temp de Ventre</h1>

    <?php
    // updatePassword.php

    include("../php/dataconnection.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST["email"];
        $newPassword = $_POST["new_password"];
        $confirmPassword = $_POST["confirm_password"];

        // Validate the new password
        if ($newPassword != $confirmPassword) {
            echo "New password and confirm password do not match.";
            exit;
        }

        // Update the password in the database for the given email
        $sql = "UPDATE customer SET customer_pass = '$newPassword' WHERE customer_email = '$email'";
        $result = $connection->query($sql);

        if ($result) {
            echo "<script>alert('Password updated successfully!'); window.location.href = '../html/index.html';</script>";
        } else {
            echo "Error updating password.";
        }        
    }
    ?>
    
</body>
</html>
