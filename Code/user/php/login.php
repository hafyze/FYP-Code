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
    <h2>Login</h2>

    <?php if (isset($errorMessage)) { ?>
        <p><?php echo $errorMessage; ?></p>
    <?php } ?>

    <form action="../php/login.php" method="POST">
        <label for="customer_email">Email:</label>
        <input type="text" name="customer_email" placeholder="abc@gmail.com" required><br>

        <label for="customer_pass">Password:</label>
        <input type="password" name="customer_pass" placeholder="123" required><br>

        <input type="submit" value="Login">
        
        <?php if (isset($_POST['customer_email'])) { ?>
            <a href="../php/resetPassword.php?email=<?php echo urlencode($_POST['customer_email']); ?>">Forgot Password?</a>
        <?php } ?>
    </form>

<?php
session_start();

include("../php/dataconnection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_email = $_POST["customer_email"];
    $customer_pass = $_POST["customer_pass"];

    // query from db
    $sql = "SELECT * FROM customer
            WHERE customer_email = '$customer_email' AND customer_pass = '$customer_pass'";

    $result = $connection->query($sql);

    // check if email valid in db
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION["customer_id"] = $row['customer_id'];
        echo "Login successful!";
        // Redirect to main page
        header("Location: ../html/index.html");
        exit;
    } else {
        $errorMessage = "Invalid email or password";
    }
}

// Forgot Password functionality
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["forgot"])) {
    $forgotEmail = $_GET["forgot"];
    // Check if the email exists in the database
    $sql = "SELECT * FROM customer WHERE customer_email = '$forgotEmail'";
    $result = $connection->query($sql);
    if (mysqli_num_rows($result) == 1) {

        // Email exists, perform the password reset process

        // Generate a unique token for password reset
        $resetToken = bin2hex(random_bytes(32));

        // Store the token and associated email in a separate table
        $resetTable = "password_reset";
        $sql = "INSERT INTO $resetTable (email, token) VALUES ('$forgotEmail', '$resetToken')";
        $connection->query($sql);

        // Send the password reset email to the user
        $resetLink = "../php/resetPassword.php?token=$resetToken";
        $resetEmailSubject = "Password Reset";
        $resetEmailBody = "Click the following link to reset your password: $resetLink";
        // Send the email using your preferred email sending method (e.g., PHP's mail() function, third-party library, etc.)
    } else {
        echo "<script>alert('Email not found.');</script>";
    }
}
?>
