<!DOCTYPE html>
<html>

<head>
    <title>Temp de Ventre</title>

    <script src="https://kit.fontawesome.com/fd65af94cc.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css" <?php echo time(); ?>>
    <link rel="stylesheet" href="../css/cart.css" <?php echo time(); ?>>

</head>

<body>
    <h1>Temp de Ventre</h1>

    <div class="profile">
        
        <a href="../php/profile.php">
            <i class="fa-solid fa-user"></i>
            <p>User Profile</p>
        </a>
    </div>

    <form action="../php/logout.php" method="POST">
        <input style="float: right;" type="submit" value="Logout">
    </form>
        

    <header>
        <nav id="navbar">
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">About Us</a></li>
                <li><a href="../html/specialty.html">Specialty</a></li>
                <li><a href="#">News</a></li>
                <li><a href="#">Contact Us</a></li>
				<li><a href="#">Order Now</a></li>
				
            </ul>
        </nav>
    </header>


    <div style="position: relative;">
    <form action="../php/searchFood.php" method="GET">
            <input type="text" name="keyword" placeholder="Enter a keyword" required>
            <button type="submit">Search</button>
        </form>
        
        
    </div>

    <?php
session_start();

if (!isset($_SESSION['customer_id'])) {
    header("Location: ../html/login.html");
    exit;
}

include("../php/dataconnection.php");

if (isset($_POST['product_id']) && isset($_POST['action']) && $_POST['action'] === 'remove') {
    $productID = $_POST['product_id'];
    $customerID = $_SESSION['customer_id'];

    $sql = "DELETE FROM cart WHERE customer_id = '$customerID' AND product_id = '$productID'";

    if ($connection->query($sql) === true) {
        echo "<p>Item removed from cart successfully.</p>";
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
        echo "<p> <i class='fa-solid fa-database'></i>   Quantity : $quantity</p>";
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