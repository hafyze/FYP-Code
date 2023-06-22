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

include("../php/dataconnection.php");

if (isset($_SESSION['cart'])) {
    $cartItems = $_SESSION['cart'];

        if (!empty($cartItems)) {
            foreach ($cartItems as $key => $item) {
                if (is_array($item) && isset($item['product'])) {

                        $productName = $item['product'];
                        $quantity = $item['quantity'];

                        //Need to query price data from DB
                        $query = "SELECT price FROM product WHERE product_name = '$productName'";
                        $result = mysqli_query($connection, $query);
                        $row = mysqli_fetch_assoc($result);
                        $price = $row['price'];

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

    <div id="payment">
        <p>*If insert bank please show proof of payment by uploading img. Bank Info is below</p>
        <form action="processPayment.php" method="POST" enctype="multipart/form-data">
            <div>
                <label for="paymentMode">Payment Mode:</label>
                <input type="radio" id="cash" name="paymentMode" value="cash" class="payment-radio">
                <label for="cash">Cash</label>
                <input type="radio" id="bank" name="paymentMode" value="bank" class="payment-radio">
                <label for="bank">Bank</label>
            </div>

            <!-- Additional input fields for bank details, if applicable -->
            <div id="bank_details">
                <label for="bankName">Bank Name:</label>
                <input type="text" id="bankName" name="bankName">
                <!-- Add more bank details fields as needed -->
            </div>
            <div id="proof_of_payment">
                <label for="payProof">Proof of Payment: </label>
                <input type="file" id="payProof" name="payProof">
            </div>

            <button class="submitBtn" type="submit">Proceed to Payment</button>
        </form>
    </div>

    <div id="bankContact">
        <p>Maybank XXXXXXXX</p> <br>
        <p>Temp de Ventre</p>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</body>

<script src="../js/index.js"></script>

</html>