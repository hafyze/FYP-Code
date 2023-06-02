<?php
// Establish database connection
session_start();

include("../php/dataconnection.php");


// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve login form data
    $customer_email = $_POST["customer_email"];
    $customer_pass = $_POST["customer_pass"];

    // Check customer from DB
    $sql = "SELECT * FROM customer
            WHERE customer_email = '$customer_email' AND customer_pass = '$customer_pass'";
    
    $result = $connection->query($sql);

    //Checks if customer is available from DB
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION["customer_id"] = $row['customer_id'];
        echo "Login successful!";
        //Redirect to index.html
        header("Location: ../html/index.html");
        exit;
    } else {
        echo "Invalid email or password";
    }
}
?>

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
        <input type="password" name="customer_pass" placeholder="123"required><br>

        <input type="submit" value="Login">
    </form>
</body>
</html>