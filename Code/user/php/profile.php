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
$custId = $_SESSION['customer_id'];
$query = "SELECT * FROM customer 
                    WHERE customer_id = $custId";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($result);
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
    <h1>User Profile</h1>
    <p>Name: <?php echo $row['customer_name']; ?></p>
    <p>Contact: <?php echo $row['customer_contact']; ?></p>
    <p>Email: <?php echo $row['customer_email']; ?></p>

    <a href="../php/editProfile.php">Edit Profile</a>
</body>
</html>
