<?php
session_start();

if (!isset($_SESSION['customer_id'])) {
    header("Location: ../html/login.html");
    exit;
}

include('../php/dataconnection.php');

// Get customer info from db
$custId = $_SESSION['customer_id'];
$query = "SELECT * FROM customer 
                    WHERE customer_id = $custId";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>

<!DOCTYPE html>
<html>

<head>
    <title>Temp de Ventre - User Profile</title>

    <script src="https://kit.fontawesome.com/fd65af94cc.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css?v=<?php echo time(); ?>">

    <style>
        body {
            margin: 0;
            text-align: center;
            padding-top: 50px;
        }

        h2 {
            font-size: 20px;
        }

        p {
            font-size: 16px;
            margin-bottom: 10px;
        }

        a {
            color: #337ab7;
            text-decoration: none;
        }

        a:hover {
            color: #23527c;
        }
    </style>
</head>

<body>
    <h1><a href="../html/index.html">Temp de Ventre</a></h1>
    <h2><i class="fa-solid fa-user"></i> User Profile</h2>

    <p><i class="fa-solid fa-signature"></i>
        Name: <?php echo $row['customer_name']; ?>
    </p>

    <p><i class="fa-solid fa-phone"></i>
        Contact: <?php echo $row['customer_contact']; ?>
    </p>

    <p><i class="fa-solid fa-envelope"></i>
        Email: <?php echo $row['customer_email']; ?>
    </p>

    <a href="../php/editProfile.php">
        <i class="fa-regular fa-pen-to-square"></i>
        Edit Profile
    </a>
</body>

</html>