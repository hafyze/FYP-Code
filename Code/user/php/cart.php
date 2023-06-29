<!DOCTYPE html>
<html>

<head>
    <title>Temp de Ventre</title>

    <script src="https://kit.fontawesome.com/fd65af94cc.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
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

// Handle adding items to the cart
if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $productID = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $customerID = $_SESSION['customer_id'];

    // Prepare the SQL statement to insert the item into the cart
    $sql = "INSERT INTO cart (customer_id, product_id, quantity) VALUES ('$customerID', '$productID', '$quantity')";

    if ($connection->query($sql) === true) {
        // Display success message or perform any other actions
        echo "<p>Item added to cart successfully.</p>";
    } else {
        // Display error message
        echo "<p>Error adding item to cart: " . $connection->error . "</p>";
    }
}

// Retrieve and display items in the cart
$sql = "SELECT * FROM cart INNER JOIN product ON cart.product_id = product.product_id WHERE cart.customer_id = '{$_SESSION['customer_id']}'";
$result = $connection->query($sql);

if ($result->num_rows > 0) {
    echo "<h2>Cart Items:</h2>";

    while ($row = $result->fetch_assoc()) {
        $productID = $row['product_id'];
        $productName = $row['product_name'];
        $quantity = $row['quantity'];

        echo "<p>Product Name: $productName</p>";
        echo "<p>Quantity: $quantity</p>";
        
        // Remove item from cart form
        echo '<form action="" method="POST">';
        echo '<input type="hidden" name="product_id" value="' . $productID . '">';
        echo '<input type="hidden" name="action" value="remove">';
        echo '<button type="submit">Remove</button>';
        echo '</form>';
        
        echo "<hr>";
    }

    // "Proceed to Checkout" button
    echo '<form action="../php/payment.php" method="POST">';
    echo '<button type="submit">Proceed to Checkout</button>';
    echo '</form>';
} else {
    echo "<p>Cart is empty.</p>";
}

// Close the database connection
$connection->close();
?>


</body>

<script src="../js/index.js"></script>

</html>