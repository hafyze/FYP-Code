<?php 
    session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Temps de Ventre</title>

    <script src="https://kit.fontawesome.com/fd65af94cc.js" crossorigin="anonymous"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link rel="stylesheet" href="../css/style.css" <?php echo time(); ?>>
    <link rel="stylesheet" href="../css/payment.css" <?php echo time(); ?>>
    <script src="../js/index.js"></script>

</head>

<style>
        body{
            background-color: #ffffff;
            background-image: linear-gradient(315deg, #ffffff 0%, #d7e1ec 74%);       
        }
        .payment-form .form-control {
            width: 100%;
            max-width: 300px; 
            margin: 5px auto;
        }

        h3{
            text-align: center;
        }

        header{
            border-radius: 20px;
        }

        #navbar ul li a {
            display: block;
            padding: 10px 15px;
            text-decoration: none;
            color: white;
            font-weight: bold;
            border-radius: 8%;
            transition: all 0.3s ease;
        }

        #navbar ul li a:hover {
            color: #333;
            background-color: #f5f5f5;
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
            background-color: #333;
            transition-duration: 1.3s;
        }

        #tdvText a:hover{
            text-decoration: none;
        }

        .table-rounded{
            border-radius: 10px;
        }

        .table td{
            background-color: white;
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
        <i class="fa-solid fa-right-from-bracket"></i>
        <input type="submit" value="Logout">
    </form>


    <header>

        <nav id="navbar">
            <ul>
                <li><a href="../html/index.html">Home</a></li>
                <li><a href="../html/index.html#aboutUs">About Us</a></li>
                <li><a href="../html/specialty.html">Specialty</a></li>
                <li><a href="../html/contactUs.html">Contact Us</a></li>
                <li><a href="../php/cart.php">Cart</a></li>
                <li><a href="../html/trackOrder.html">Track Order</a></li>
            </ul>
        </nav>
    </header>

    <h2>Cart Details</h2>

    <div class="container">
        <?php
        include("../php/dataconnection.php");

        // Query item from cart
        $query = "SELECT c.cart_id, p.product_name, c.quantity, p.price 
                FROM cart AS c
                INNER JOIN product AS p ON c.product_id = p.product_id
                WHERE c.customer_id = '{$_SESSION['customer_id']}'";
        $result = $connection->query($query);

        if ($result->num_rows > 0) {
            // Display the table header
            echo "
            <div class='table-responsive'>
                <table class='table table-bordered table-hover table-rounded'>
                    <thead class='thead-dark'>
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
            while ($row = $result->fetch_assoc()) {
                $cartID = $row['cart_id'];
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
        $connection->close();
    ?>
    </div>


    <h2>Payment Details</h2>

    <form action="../php/processPayment.php" method="POST" enctype="multipart/form-data" class="payment-form">
        <div class="form-group">
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="deliveryOption">Delivery or Self-Pickup:</label>
            <select id="deliveryOption" name="deliveryOption" class="form-control" required>
                <option value="delivery">Delivery</option>
                <option value="self_pickup">Self-Pickup</option>
            </select>
        </div>

        <div id="extraFieldsContainer">

            <div class="form-group">
                <label for="paymentMethod">Payment Method:</label>
                <select id="paymentMethod" name="paymentMethod" class="form-control" required>
                    <option value="">Select Payment Method</option>
                    <option value="cash">Cash</option>
                    <option value="card">Card</option>
                    <option value="bank">Bank Transfer</option>
                    <option value="qrcode">QR Code</option>
                </select>
            </div>

            <div id="cardFields" class="extra-fields">
                <div class="form-group">
                    <label for="cardNumber">Card Number:</label>
                    <input type="text" id="cardNumber" name="cardNumber" class="form-control" placeholder="Enter card number">
                </div>
                <div class="form-group">
                    <label for="cardExpiryDate">Expiration Date:</label>
                    <input type="text" id="cardExpiryDate" name="cardExpiryDate" class="form-control" placeholder="Enter expiry date">
                </div>
                <div class="form-group">
                    <label for="cardSecurity">Security Pin:</label>
                    <input type="text" id="cardSecurity" name="cardSecurity" class="form-control" placeholder="Enter security pin">
                </div>
            </div>

            <div id="bankFields" class="extra-fields">
                <div class="form-group">
                    <label for="proofOfPayment">Proof of Payment:</label>
                    <input type="file" id="proofOfPayment" name="proofOfPayment" class="form-control-file">
                    <p>Bank account provided below</p>
                </div>
            </div>

            <div id="qrFields" class="extra-fields">
                <label for="qrCode">QR Code:</label>
                <p>Scan the code below</p>
            </div>
        </div>

        <div class="form-group">
            <label for="promoCode">Promo Code:</label>
            <input type="text" id="promoCode" name="promoCode" class="form-control" placeholder="Enter promo code(if applicable)">
        </div>

        <button type="submit" class="btn btn-primary">Proceed to Payment</button>
    </form>

    <div id="bankContact" class="mt-4">
        <h3>Bank Details</h3>
        <p>Temps de Ventre Bank</p>
        <p>Maybank XXXXXXXX</p>
        <p>Temps de Ventre</p>
        <p><img id="qrCodeImage" name="qrCode" src="../img/qrcode.png" alt="QR Code" style="width:100px;"></p>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/index.js"></script>
    <script src="../js/payment.js"></script>
</body>

</html>
