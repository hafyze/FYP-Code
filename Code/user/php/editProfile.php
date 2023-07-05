<?php
    session_start();

    if (!isset($_SESSION['customer_id'])) {
        header("Location: ../php/login.php");
        exit;
    }

    include('../php/dataconnection.php');

    // Get customer info from db
    $custId = $_SESSION['customer_id'];
    $query = "SELECT * FROM customer WHERE customer_id = $custId";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($result);

    // Declare related variables after submitting the form
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $custName = $_POST['customer_name'];
        $custContact = $_POST['customer_contact'];
        $custEmail = $_POST['customer_email'];
        $custPass = $_POST['customer_pass'];
        $currentPass = $_POST['current_password'];
    
        // Retrieve the current password from the database for the logged-in user
        $currentPassQuery = "SELECT customer_pass FROM customer WHERE customer_id = $custId";
        $currentPassResult = mysqli_query($connection, $currentPassQuery);
        $currentPassRow = mysqli_fetch_assoc($currentPassResult);
        $storedPass = $currentPassRow['customer_pass'];
    
        // Validate the current password
        if ($currentPass !== $storedPass) {
            $error_message = "Error: Incorrect current password.";
            echo "<script>alert('$error_message');</script>";
        } 
        // Validation for email format
        elseif (!filter_var($custEmail, FILTER_VALIDATE_EMAIL)) {
            $error_message = "Error: Invalid email format.";
            echo "<script>alert('$error_message');</script>";
        } 
        // Validation for phone number format
        elseif (!preg_match("/^01[0-9]-[0-9]{7,8}$/", $custContact)) {
            $error_message = "Error: Invalid phone number format. Use format 01x-xxxxxxx.";
            echo "<script>alert('$error_message');</script>";
        } 
        else {
            // Update the user data in the database
            $updateQuery = "UPDATE customer 
                            SET customer_name = '$custName', 
                            customer_contact = '$custContact', 
                            customer_email = '$custEmail', 
                            customer_pass = '$custPass' 
                            WHERE customer_id = $custId";
            mysqli_query($connection, $updateQuery);
    
            // Redirect to the profile page
            header("Location: ../php/profile.php?success=1");
            exit;
        }
    }
?>


<!DOCTYPE html>
<html>

<head>
    <title>Temps de Ventre</title>

    <script src="https://kit.fontawesome.com/fd65af94cc.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/profile.css">
</head>

<style>
    #tdvText{
        width: fit-content;
        margin: 0 auto;
        padding: 15px;
        background-color: #657566;
        border-radius: 15px;
        text-decoration: none;
    }

    #tdvText a{
        color: white;
    }

    #tdvText:hover{
        background-color: #333;
        transition-duration: 1.3s;
    }

    #tdvText a:hover{
        text-decoration: none;
    }
</style>

<body>
    <div class="container">
        <h1 id="tdvText"><a href="../html/index.html">Temps de Ventre</a></h1>
        <h2><i class="fa-regular fa-pen-to-square"></i>Edit Profile</h2>
        <form action="../php/editProfile.php" method="POST">
            <div class="form-group">
                <label for="customer_name">
                    <i class="fa-solid fa-user"></i> Name:
                </label>
                <input type="text" class="form-control" name="customer_name" value="<?php echo $row['customer_name']; ?>">
            </div>

            <div class="form-group">
                <label for="customer_contact">
                    <i class="fa-solid fa-phone"></i> Contact:
                </label>
                <input type="text" class="form-control" name="customer_contact" value="<?php echo $row['customer_contact']; ?>">
            </div>

            <div class="form-group">
                <label for="customer_email">
                    <i class="fa-solid fa-envelope"></i> Email:
                </label>
                <input type="email" class="form-control" name="customer_email" value="<?php echo $row['customer_email']; ?>">
            </div>

            <div class="form-group">
                <label for="current_password">
                    <i class="fa-solid fa-lock"></i> Current Password:
                </label>
                <input type="password" class="form-control" name="current_password" required>
            </div>

            <div class="form-group">
                <label for="customer_pass">
                    <i class="fa-solid fa-lock"></i> Password:
                </label>
                <input type="password" class="form-control" name="customer_pass" value="<?php echo $row['customer_pass']; ?>">
            </div>

            <button type="submit" class="btn btn-primary">Update Profile</button>
        </form>
    </div>

    <script src="../js/index.js"></script>
</body>

</html>
