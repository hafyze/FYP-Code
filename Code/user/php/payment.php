<!DOCTYPE html>
<html>

<head>
    <title>Temp de Ventre</title>

    <script src="https://kit.fontawesome.com/fd65af94cc.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css" <?php echo time(); ?>>
    <link rel="stylesheet" href="../css/payment.css" <?php echo time(); ?>>
    <script src="../js/index.js"></script>

</head>

<body>
    <h1><a href="../html/index.html">Temp de Ventre</a></h1>

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

    <h2>Cart Details</h2>
            <!-- Loop through the cart items and display the details -->
            <?php
include("../php/dataconnection.php");

// Query the cart items from the food_order table
$query = "SELECT fo.order_id, p.product_name, fo.quantity, p.price 
          FROM food_order AS fo
          INNER JOIN product AS p ON fo.product_id = p.product_id";
$result = mysqli_query($connection, $query);

if (mysqli_num_rows($result) > 0) {
    // Display the table header
    echo "
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
    ";

    // Initialize total price
    $totalPrice = 0;

    // Iterate over cart items
    while ($row = mysqli_fetch_assoc($result)) {
        $orderID = $row['order_id'];
        $productName = $row['product_name'];
        $quantity = $row['quantity'];
        $price = $row['price'];
        $subtotal = $quantity * $price;
        $totalPrice += $subtotal;

        // Display the cart item row
        echo "
        <tr>
            <td>$productName</td>
            <td>$quantity</td>
            <td>RM$price</td>
            <td>RM$subtotal</td>
        </tr>
        ";
    }

    // Display the total price
    echo "
        <tr>
            <td colspan='3'>Total</td>
            <td>RM$totalPrice</td>
        </tr>
    ";

    // Close the table
    echo "
        </tbody>
    </table>
    ";
} else {
    echo "<p>Cart is empty</p>";
}

// Close the database connection
mysqli_close($connection);
?>

    <h2>Payment Details</h2>

    <form action="../php/processPayment.php" method="POST" enctype="multipart/form-data">
        <label for="address">Address:</label>
        <input type="text" id="address" name="address" required>

        <label for="deliveryOption">Delivery or Self-Pickup:</label>
        <select id="deliveryOption" name="deliveryOption" required>
            <option value="delivery">Delivery</option>
            <option value="self_pickup">Self-Pickup</option>
        </select>

    <div id="extraFieldsContainer">

    <label for="paymentMethod">Payment Method:</label>
    <select id="paymentMethod" name="paymentMethod" required>
        <option value="">Select Payment Method</option>
        <option value="cash">Cash</option>
        <option value="card">Card</option>
        <option value="bank">Bank Transfer</option>
        <option value="qrcode">QR Code</option>
    </select>

    <div id="cardFields" class="extra-fields">
        <label for="cardNumber">Card Number:</label>
        <input type="text" id="cardNumber" name="cardNumber" placeholder="Enter card number">
    </div>

    <div id="bankFields" class="extra-fields">
        <label for="proofOfPayment">Proof of Payment:</label>
        <input type="file" id="proofOfPayment" name="proofOfPayment">
    </div>

    <div id="qrFields" class="extra-fields">
        <label for="qrCode">QR Code:</label>
        <img src="../img/qrcode.png" alt="QR Code">
    </div>

    </div>

        <!-- Additional fields for bank transfer details or other payment methods -->

        <button type="submit">Proceed to Payment</button>
    </form>

    <div id="bankContact">
        <p>Maybank XXXXXXXX</p> <br>
        <p>Temp de Ventre</p>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/index.js"></script>

    <script src="../js/payment.js">
</body>

</html>
