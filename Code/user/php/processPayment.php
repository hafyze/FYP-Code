    <?php
    include("../php/dataconnection.php");

    //get from form submission in payment.php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve the form data
        $address = $_POST["address"];
        $deliveryOption = $_POST["deliveryOption"];
        $paymentMethod = $_POST["paymentMethod"];

        // get customer ID from the session since login
        session_start();
        if (isset($_SESSION["customer_id"])) {
            $customerID = $_SESSION["customer_id"];
        }

        // Fetch the cart_id for the customer
        $cartQuery = "SELECT cart_id 
                        FROM cart 
                        WHERE customer_id = ?";

        $cartStmt = mysqli_prepare($connection, $cartQuery);
        mysqli_stmt_bind_param($cartStmt, "i", $customerID);
        mysqli_stmt_execute($cartStmt);
        $cartResult = mysqli_stmt_get_result($cartStmt);

        if ($cartRow = mysqli_fetch_assoc($cartResult)) {
            $cartID = $cartRow["cart_id"];

            // Fetch the cart items for the customer
            $query = "SELECT c.product_id, c.quantity, p.product_name, p.price 
                        FROM cart c INNER JOIN product p 
                        ON c.product_id = p.product_id 
                        WHERE c.customer_id = ?";

            $stmt = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($stmt, "i", $customerID);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            // Calculate the total fee and prepare the payment details 
            $totalFee = 0;
            $paymentDetails = "";
            while ($row = mysqli_fetch_assoc($result)) {
                $productID = $row["product_id"];
                $productName = $row["product_name"];
                $quantity = $row["quantity"];
                $price = $row["price"];
                $subtotal = $quantity * $price;
                $totalFee += $subtotal;

                // Prepare the payment details string
                $paymentDetails .= "Product: $productName (ID: $productID), Quantity: $quantity, Subtotal: $subtotal\n";
            }

            // Insert the payment details into the database
            $insertQuery = "INSERT INTO payment (payment_type, fee, cart_id) 
                            VALUES (?, ?, ?)";
            $insertStmt = mysqli_prepare($connection, $insertQuery);

            mysqli_stmt_bind_param($insertStmt, "sdi", $paymentMethod, $totalFee, $cartID);
            mysqli_stmt_execute($insertStmt);

            // Check if the payment insertion was successful
            if (mysqli_stmt_affected_rows($insertStmt) > 0) {
                // Payment successfully processed
                // You can perform any additional actions here, such as clearing the cart, sending email notifications, etc.

                // Delete the cart records associated with the customer
                $deleteCartQuery = "DELETE FROM cart WHERE customer_id = ?";
                $deleteCartStmt = mysqli_prepare($connection, $deleteCartQuery);
                mysqli_stmt_bind_param($deleteCartStmt, "i", $customerID);
                mysqli_stmt_execute($deleteCartStmt);

                // Check if the cart deletion was successful
                if (mysqli_stmt_affected_rows($deleteCartStmt) > 0) {
                    // Cart records successfully deleted
                    // You can perform any additional actions here or display a success message
                } else {
                    // Cart deletion failed
                    // Handle the failure case or display an error message
                }

                // Close the delete cart prepared statement
                mysqli_stmt_close($deleteCartStmt);

                // Redirect to a success page or display a success message
                echo "<p>Payment Success</p><script>alert('Payment Success'); window.location.href = '../html/index.html';</script>";
                exit();
            } else {
                // Payment insertion failed
                // Handle the failure case, such as redirecting to an error page or displaying an error message
                echo "<p>Payment Failed</p><script>alert('Payment Failed'); window.location.href = '../html/index.html';</script>";
                exit();
            }
        } else {
            // Handle the case when the cart ID is not found for the customer
            exit("Cart ID not found for the customer.");
        }
    } else {
        exit("Invalid form submission.");
    }
?>