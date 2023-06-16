<?php
session_start();

if (!isset($_SESSION['customer_id'])) {
    header("Location: ../php/login.php");
    exit;
}

include('../php/dataconnection.php');

// Get customer info from db
$custId = $_SESSION['customer_id'];
$query = "SELECT * FROM customer
                    WHERE customer_id = $custId";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($result);

// declare related variable after submitting the form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $custName = $_POST['customer_name'];
    $custContact = $_POST['customer_contact'];
    $custEmail = $_POST['customer_email'];
    $custPass = $_POST['customer_pass'];

    // Update the user data in database
    $updateQuery = "UPDATE customer 
                    SET customer_name = '$custName', 
                    customer_contact = '$custContact', 
                    customer_email = '$custEmail', 
                    customer_pass = '$custPass' 
                    WHERE customer_id = $custId";
    mysqli_query($connection, $updateQuery);

    // Redirect to profile page
    header("Location: ../php/profile.php?success=1");
    exit;
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
    <h1><a href="../html/index.html"></a></h1>
    <h2>Edit Profile</h2>
    <form action="../php/editProfile.php" method="POST">
        <label for="customer_name">Name:</label>
        <input type="text"  name="customer_name" value="<?php echo $row['customer_name']; ?>"><br>

        <label for="customer_contact">Contact:</label>
        <input type="text"  name="customer_contact" value="<?php echo $row['customer_contact']; ?>"><br>

        <label for="customer_email">Email:</label>
        <input type="email"  name="customer_email" value="<?php echo $row['customer_email']; ?>"><br>

        <label for="customer_pass">Password:</label>
        <input type="password"  name="customer_pass" value="<?php echo $row['customer_pass']; ?>"><br>

        <input type="submit" value="Update Profile">
    </form>

    <script src="../js/index.js"></script>
</body>
</html>