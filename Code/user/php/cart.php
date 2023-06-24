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
            header("Location: ../php/login.php");
            exit;
        }
        
        include("../php/dataconnection.php");

        // Handle quantity update and item removal
        if (isset($_POST['order_id'])) {
            $orderID = $_POST['order_id'];
            $action = $_POST['action'];

            if ($action === 'update') {
                $quantity = $_POST['quantity'];

                // Prepare the SQL statement to update the quantity
                $sql = "UPDATE food_order SET quantity = '$quantity' WHERE order_id = '$orderID'";

                if ($connection->query($sql) === true) {
                    // Display success message
                    echo "<p>Quantity updated successfully.</p>";
                    header("Location: ../php/cart.php");
                } else {
                    // Display error message
                    echo "<p>Error updating quantity: " . $connection->error . "</p>";
                }
            } elseif ($action === 'remove') {
                // Prepare the SQL statement to delete the item from the cart
                $sql = "DELETE FROM food_order WHERE order_id = '$orderID'";

                if ($connection->query($sql) === true) {
                    // Display success message
                    echo "<p>Item removed from cart successfully.</p>";
                    header("Location: ../php/cart.php");
                } else {
                    // Display error message
                    echo "<p>Error removing item from cart: " . $connection->error . "</p>";
                }
            }
        }

        // Retrieve and display items in the cart
        $sql = "SELECT * FROM food_order INNER JOIN product ON food_order.product_id = product.product_id";
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
            echo "<h2>Cart Items:</h2>";

            while ($row = $result->fetch_assoc()) {
                $orderID = $row['order_id'];
                $productName = $row['product_name'];
                $quantity = isset($row['quantity']) ? $row['quantity'] : null;
            
                echo "<p>Product Name: $productName</p>";
            
                if ($quantity !== null) {
                    echo "<p>Quantity: $quantity</p>";
            
                    // Update quantity form
                    echo '<form action="" method="POST">';
                    echo '<input type="hidden" name="order_id" value="' . $orderID . '">';
                    echo '<input type="hidden" name="action" value="update">';
                    echo '<label for="quantity">Update Quantity:</label>';
                    echo '<input type="number" name="quantity" value="' . $quantity . '" min="1" required>';
                    echo '<button type="submit">Update</button>';
                    echo '</form>';
                } else {
                    echo "<p>Quantity: Not available</p>";
                }
            
                // Remove item form
                echo '<form action="" method="POST">';
                echo '<input type="hidden" name="order_id" value="' . $orderID . '">';
                echo '<input type="hidden" name="action" value="remove">';
                echo '<button type="submit">Remove</button>';
                echo '</form>';
            
                echo "<hr>";
            }
            
            // "Pay Now" button
            echo '<form action="../php/payment.php" method="POST">';
            echo '<button type="submit">Pay Now</button>';
            echo '</form>';
            } 
            else {
                echo "<p>Cart is empty.</p>";
            }

            // Close the database connection
            $connection->close();
            ?>

</body>

<script src="../js/index.js"></script>

</html>