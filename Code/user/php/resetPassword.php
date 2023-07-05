<!DOCTYPE html>
<html>
    
<head>
    <title>Temps de Ventre</title>
    <script src="https://kit.fontawesome.com/fd65af94cc.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css?v=<?php echo time(); ?>">
</head>

<body>
    <h1>Temps de Ventre</h1>

    <h2>Reset Password</h2>

    <form action="../php/updatePassword.php" method="POST">
        <label for="email">Email:</label>
        <input type="email" name="email" required><br>

        <label for="new_password">New Password:</label>
        <input type="password" name="new_password" required><br>

        <label for="confirm_password">Confirm Password:</label>
        <input type="password" name="confirm_password" required><br>

        <input type="submit" value="Reset Password">
    </form>

</body>
</html>
