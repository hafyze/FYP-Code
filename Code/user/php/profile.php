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
    <title>Temps de Ventre - User Profile</title>

    <script src="https://kit.fontawesome.com/fd65af94cc.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css?v=<?php echo time(); ?>">

    <style>
        body {
            margin: 0;
            text-align: center;
            padding-top: 50px;
            background-color: #ffffff;
            background-image: linear-gradient(315deg, #ffffff 0%, #d7e1ec 74%);       
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
        color: ;
        background-color: #333;
        transition-duration: 1.3s;
    }

    #tdvText a:hover{
        text-decoration: none;
    }
    </style>
</head>

<body>
    <h1 id="tdvText"><a href="../html/index.html">Temps de Ventre</a></h1>
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