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
    // resetPassword.php

    // Check if the email is provided in the URL
    if (isset($_GET['email'])) {
        $email = $_GET['email'];
        // Display the form to enter a new password
        ?>

        <h2>Reset Password</h2>

        <form action="../php/updatePassword.php" method="POST">
            <input type="hidden" name="email" value="<?php echo $email; ?>">
            <label for="new_password">New Password:</label>
            <input type="password" name="new_password" required><br>

            <label for="confirm_password">Confirm Password:</label>
            <input type="password" name="confirm_password" required><br>

            <input type="submit" value="Reset Password">
        </form>

        <?php
    }
    ?>
</body>
</html>