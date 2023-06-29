<?php
include("../php/dataconnection.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the form data
    $address = $_POST["address"];
    $deliveryOption = $_POST["deliveryOption"];
    $paymentMethod = $_POST["paymentMethod"];

    // Retrieve the customer ID from the session
    session_start();
    if (isset($_SESSION["customer_id"])) {
        $customerID = $_SESSION["customer_id"];
    } else {
        // Handle the case when the customer ID is not found in the session
        // Redirect or show an error message
        exit("Customer ID not found in the session.");
    }

    // Fetch the cart items for the customer
    $query = "SELECT c.cart_id, c.product_id, c.quantity, p.product_name, p.price FROM cart c INNER JOIN products p ON c.product_id = p.product_id WHERE c.customer_id = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "i", $customerID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Calculate the total fee and prepare the payment details for insertion
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
    $insertQuery = "INSERT INTO payment (payment_type, fee, cart_id) VALUES (?, ?, ?)";
    $insertStmt = mysqli_prepare($connection, $insertQuery);
    mysqli_stmt_bind_param($insertStmt, "sdi", $paymentMethod, $totalFee, $cartID);
    mysqli_stmt_execute($insertStmt);

    // Check if the payment insertion was successful
    if (mysqli_stmt_affected_rows($insertStmt) > 0) {
        // Payment successfully processed
        // You can perform any additional actions here, such as clearing the cart, sending email notifications, etc.

        // Redirect to a success page or display a success message
        header("Location: paymentSuccess.php");
        exit();
    } else {
        // Payment insertion failed
        // Handle the failure case, such as redirecting to an error page or displaying an error message
        header("Location: paymentError.php");
        exit();
    }
} else {
    // Handle the case when the form is not submitted
    // Redirect or show an error message
    exit("Form not submitted.");
}
?>
