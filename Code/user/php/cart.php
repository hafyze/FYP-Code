<!DOCTYPE html>
<html>

<head>
    <title>Temps de Ventre</title>

    <script src="https://kit.fontawesome.com/fd65af94cc.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css" <?php echo time(); ?>>
    <link rel="stylesheet" href="../css/cart.css" <?php echo time(); ?>>

</head>

<style>
    /* Profile styles */
    body{
        background-color: #ffffff;
        background-image: linear-gradient(315deg, #ffffff 0%, #d7e1ec 74%);       
    }

    header{
        border-radius: 20px;
    }

    h1{

    }

    .profile {
        text-align: center;
        margin-top: 20px;
    }

    .profile-link {
        display: inline-block;
        text-decoration: none;
        color: #333;
        margin: 5px;
    }

    .profile-link i {
        display: block;
        font-size: 24px;
    }

    /* Logout form styles */
    .logout-form {
        text-align: right;
        margin: 20px 20px 0 20px;
    }

    .logout-form input[type="submit"] {
        background-color: #333;
        color: #fff;
        border: none;
        padding: 10px 20px;
        font-size: 16px;
        cursor: pointer;
    }

    .logout-form input[type="submit"]:hover {
        background-color: #555;
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

        #search-form input[type="text"] {
            width: 300px;
            padding: 8px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 20px;
        }
</style>

<body>
    <h1 id="tdvText"><a href="../html/index.html">Temps de Ventre</a></h1>

    <div class="profile">
        <a class="profile-link" href="../php/profile.php">
            <i class="fa-solid fa-user"></i>
            <p>User Profile</p>
        </a>
    </div>

    <form class="logout-form" action="../php/logout.php" method="POST">
        <input type="submit" value="Logout">
    </form>
        

    <header>
        <nav id="navbar">
            <ul>
                <li><a href="../html/index.html">Home</a></li>
                <li><a href="../html/index.html#aboutUs">About Us</a></li>
                <li><a href="../html/specialty.html">Specialty</a></li>
                <li><a href="../html/contactUs.html">Contact Us</a></li>
                <li><a href="../html/trackOrder.html">Track Order</a></li>
            </ul>
        </nav>
    </header>

    <div id="cart-section" style="margin: 4px auto;">
        <h1><a href="../php/cart.php">Cart</a></h1>

        <div id="search-form">
            <form action="../php/searchFood.php" method="GET">
                <input type="text" name="keyword" placeholder="Search for Food Here" required>
                <button type="submit">Search</button>
            </form>
        </div>
    </div>

    <?php
        session_start();

        if (!isset($_SESSION['customer_id'])) {
            header("Location: ../html/login.html");
            exit;
        }

        include("../php/dataconnection.php");

        if (isset($_POST['product_id']) && isset($_POST['action'])) {
            if ($_POST['action'] === 'remove') {
                $productID = $_POST['product_id'];
                $customerID = $_SESSION['customer_id'];

                $sql = "DELETE FROM cart WHERE customer_id = '$customerID' AND product_id = '$productID'";

                if ($connection->query($sql) === true) {
                    echo "<p>Item removed from cart successfully.</p>";
                } 
            } elseif ($_POST['action'] === 'update_quantity') {
                $productID = $_POST['product_id'];
                $customerID = $_SESSION['customer_id'];
                $quantity = $_POST['quantity'];

                $sql = "UPDATE cart SET quantity = '$quantity' WHERE customer_id = '$customerID' AND product_id = '$productID'";

                if ($connection->query($sql) === true) {
                    echo "<p>Quantity updated successfully.</p>";
                }
            }
        }

        $sql = "SELECT * FROM cart INNER JOIN product 
                ON cart.product_id = product.product_id 
                WHERE cart.customer_id = '{$_SESSION['customer_id']}'";
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
            echo "<h2>Cart Items:</h2>";

            $totalPrice = 0; 

            while ($row = $result->fetch_assoc()) {
                $productID = $row['product_id'];
                $productName = $row['product_name'];
                $quantity = $row['quantity'];
                $price = $row['price'];
                $subtotal = $quantity * $price; 
                $totalPrice += $subtotal; 

                echo "<p> <i class='fas fa-utensils'></i>        Food: $productName</p>";
                echo "<p> <i class='fa-solid fa-database'></i>   Quantity : 
                    <form action='' method='POST'>
                        <input type='hidden' name='product_id' value='$productID'>
                        <input type='hidden' name='action' value='update_quantity'>
                        <input type='number' name='quantity' value='$quantity' min='1'>
                        <button type='submit'>Update</button>
                    </form>
                    </p>";
                echo "<p> <i class='fa-solid fa-money-bill'></i> Price : RM $price</p>";
                echo "<p> <i class='fa-solid fa-money-bill'></i> Subtotal : RM $subtotal</p>";
                

                // Delete order from cart
                echo '<form action="" method="POST">';
                echo '<input type="hidden" name="product_id" value="' . $productID . '">';
                echo '<input type="hidden" name="action" value="remove">';
                echo '<button type="submit" class="btn btn-danger">Delete</button>';
                echo '</form>';

                echo "<hr>";
            }

            echo "<p><i class='fa-solid fa-money-bill'></i> Total Price : RM $totalPrice</p>";

            // proceed to payment page
            echo '<form action="../php/payment.php" method="POST">';
            echo '<button type="submit" class="btn btn-primary">Proceed to Checkout</button>';
            echo '</form>';
        } else {
            echo "<p>Cart is empty.</p>";
        }

        $connection->close();
?>


</body>

<script src="../js/index.js"></script>

</html>