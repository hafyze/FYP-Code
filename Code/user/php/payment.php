<!DOCTYPE html>
<html>

<head>
    <title>Temp de Ventre</title>

    <script src="https://kit.fontawesome.com/fd65af94cc.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css" >

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
                <li><a href="#">Specialty</a></li>
                <li><a href="#">News</a></li>
                <li><a href="#">Contact Us</a></li>
				<li><a href="#">Order Now</a></li>
				
            </ul>
        </nav>
    </header>

    <h2>Payment Details</h2>

    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <!-- Loop through the cart items and display the details -->
            <?php
            session_start();

            if (isset($_SESSION['cart'])) {
                $cartItems = $_SESSION['cart'];

                if (!empty($cartItems)) {
                    foreach ($cartItems as $key => $item) {
                        if (is_array($item) && isset($item['product'])) {
                            $productName = $item['product'];
                            $quantity = $item['quantity'];
                            $price = 10; // Replace with the actual price of the product
                            $subtotal = $quantity * $price;

                            echo "<tr>";
                            echo "<td>$productName</td>";
                            echo "<td>$quantity</td>";
                            echo "<td>RM$price</td>";
                            echo "<td>RM$subtotal</td>";
                            echo "</tr>";
                        }
                    }
                } else {
                    echo "<tr><td colspan='4'>Cart is empty</td></tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Cart is empty</td></tr>";
            }
            ?>
        </tbody>
    </table>
    
</body>

<script src="../js/index.js"></script>

</html>