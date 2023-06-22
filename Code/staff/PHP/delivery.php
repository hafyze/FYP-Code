<!DOCTYPE html>
<body>
    <div class="container">
        <div class="content">
<?php
$page_title = 'Ruby : Agent';
include ('../../source/header.php');

echo '<div class="header">
<h1>Ruby : Product Order </h1>
</div>';

?>
<nav>
    <?php include 'mainNavigation_Agent.php'; ?>
</nav>
<?php if (isset($_COOKIE['agentID'])) {  ?>
<form action="productOrderManagement.php" method="post">
    <h3>Product Order Page</h3>

    <label>Customer Name: </label></br>
    <input class="form-fieldset" type="text" name="name" size="35" maxlength="20" value="<?php if (isset($_POST['name'])) echo $_POST['name']; ?>" /></p>

    <label>Address : </label><br>
    <input class="form-fieldset" type="text" name="address" size="35" maxlength="50" value="<?php if (isset($_POST['address'])) echo $_POST['address']; ?>" /></p>

    <label>Contact Number: </label><br>
    <input class="form-fieldset" type="text" name="contact" size="35" maxlength="10" value="<?php if (isset($_POST['contact'])) echo $_POST['contact']; ?>" /></p>
    <p><label>Product: </label>
    <select name="product">
        <?php
        require_once('../../DBconnection.php'); // Connect to the db.
        global $dbc;
        $query = mysqli_query($dbc, "SELECT * FROM products");
        $num = mysqli_num_rows($query);

        while ($product = mysqli_fetch_array($query)) {
        echo '<option value="' . $product['productID'] . '">' . $product['productName'] . ' [ '.$product['quantity'].' pcs ] </option>';
        $num--;
        }
        ?>
    </select></p>

    <label>Quantity: </label>
    <input type="text" name="quantity" size="20" maxlength="4" max=$availableQuantity value="<?php if (isset($_POST['quantity'])) echo $_POST['quantity']; ?>" /></p>

    <label>Date sold: <label>
    <input type="date" name="date" size="10" maxlength="10" value="<?php if (isset($_POST['date'])) echo $_POST['date']; ?>" />

        <?php
    // Check if the agent's ID cookie is set
        if (isset($_COOKIE['agentID'])) {
            $agentID = $_COOKIE['agentID'];
            echo '<p> <input type="hidden" name="agentID" size="20" maxlength="20" value="' . $agentID . '" readonly /></p>';
        }
        ?>

            <p><input class="button" type="submit" name="submit" value="Submit" /></p>
            <input type="hidden" name="submitted" value="true" />
        </form>


<?php
    if (isset($_POST['submitted'])) {

    require_once ('../../DBconnection.php'); // Connect to the db.
    global $dbc;

    $agentID = $_POST['agentID'];
    $productID = $_POST['product'];

    $errors = array();

    if (empty($_POST['name'])) {
        $errors[] = 'You forgot to enter the customer name.';
    } else {
        $name = $_POST['name'];
    }

    if (empty($_POST['address'])) {
        $errors[] = 'You forgot to enter the customer address.';
    } else {
        $address = $_POST['address'];
    }

    if (empty($_POST['contact'])) {
        $errors[] = 'You forgot to enter the customer contact.';
    } else {
        $contact = $_POST['contact'];
    }

    if (empty($_POST['quantity'])) {
        $errors[] = 'You forgot to enter the product quantity.';
    } else {
        if(is_numeric($_POST['quantity'])){
            $quantity = $_POST['quantity'];
        } else {
            $errors[] = 'Quantity must be a number.';
        }
    }

    if (empty($_POST['date'])) {
        $errors[] = 'You forgot to enter the date.';
    } else {
        $date = $_POST['date'];
    }


    // Check if the quantity does not exceed the product's available quantity
    $queryQuantity = "SELECT quantity FROM products WHERE productID = '$productID'";
    $resultQuantity = mysqli_query($dbc, $queryQuantity);

    if ($resultQuantity && mysqli_num_rows($resultQuantity) > 0) {
        $row = mysqli_fetch_assoc($resultQuantity);
        $availableQuantity = $row['quantity'];

        if ($availableQuantity == 0) {
            $errors[] = 'No Product Quantity Available.';
        } elseif ($quantity > $availableQuantity) {
            $errors[] = 'Quantity exceeds the available quantity.';
        } else {
            $updatedQuantity = $availableQuantity - $quantity; // Use the extracted $quantity instead of $_POST['quantity']
            $queryNewQuantity = "UPDATE products SET quantity = '$updatedQuantity' WHERE productID = '$productID'";
            $resultNewQuantity = mysqli_query($dbc, $queryNewQuantity);
        }
    }

    // echo "Product ID - $productID<br>";
    // echo "AvailableQuantity - $availableQuantity";
    
    if (empty($errors)) {

        // Check if the customer already exists
        $queryCustomer = "SELECT customerID FROM customers WHERE customerName='$name' AND address='$address' AND phoneNumber='$contact'";
        $resultCustomer = mysqli_query($dbc, $queryCustomer);

        if (mysqli_num_rows($resultCustomer) > 0) {
            // Customer exists, retrieve the customer ID
            $row = mysqli_fetch_assoc($resultCustomer);
            $customerID = $row['customerID'];
        } else {
            // Customer doesn't exist, insert the customer data
            $queryNewCustomer = "INSERT INTO customers (customerName, address, phoneNumber) VALUES ('$name', '$address', '$contact')";
            $resultNewCustomer = mysqli_query($dbc, $queryNewCustomer);

            if ($resultNewCustomer) {
                $customerID = mysqli_insert_id($dbc);
            } else {
                echo '<h1 id="mainhead">System Error</h1>';
                echo '<p>You could not add the customer due to a system error. We apologize for any inconvenience.</p>';
                echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $query . '</p>';
                exit();
            }
        }

        $productID = $_POST['product'];

        $queryOrder = "INSERT INTO orders (agentID, customerID, productID, quantity, status, orderCreated, orderUpdated) VALUES ('$agentID', '$customerID', '$productID', '$quantity', 'pending', '$date', NOW())";
        $resultOrder = mysqli_query($dbc, $queryOrder);

        if ($resultOrder) {
            $orderID = mysqli_insert_id($dbc);

            $queryOrderAdded = "
            SELECT o.orderID, o.agentID, p.productName, c.address, c.phoneNumber, o.quantity, p.price, o.orderCreated FROM orders o 
            INNER JOIN products p ON o.productID = p.productID
            INNER JOIN customers c ON o.customerID = c.customerID
            WHERE o.agentID = '$agentID' AND o.orderID = '$orderID'
            ";

            $resultOrderAdded = mysqli_query($dbc, $queryOrderAdded);
            
            if ($resultOrderAdded) {
                echo '<hr><h1 id="mainhead">Added!</h1>';
                echo "New Product Order has been added!";

                echo '<table align="center" cellspacing="0" cellpadding="5">
                <tr>
                <th class=col1>Order ID</th>
                <th class=col1>Agent ID</th>
                <th>Product Name</th>
                <th>Address</th>
                <th>Contact Number</th>
                <th>Quantity</th>
                <th>Total Price (RM)</th>
                <th>Date</th>
                </tr>';
                while ($row = @mysqli_fetch_array($resultOrderAdded, MYSQLI_ASSOC)) {
                    echo '<tr>
                    <td class=col1>' . $row['orderID'] . '</td>
                    <td class=col1>' . $row['agentID'] . '</td>
                    <td>' . $row['productName'] . '</td>
                    <td>' . $row['address'] . '</td>
                    <td>' . $row['phoneNumber'] . '</td>
                    <td>' . $row['quantity'] . ' pcs</td>
                    <td>RM' . $row['price'] . '</td>
                    <td>' . $row['orderCreated'] . '</td>
                    </tr>';
                exit();
                }

            } else {
                echo '<tr><td colspan="8">No orders found.</td></tr>';
            }

            echo '</table>';
            mysqli_close($dbc);
        } else {
            echo '<h1 id="mainhead">System Error</h1>';
            echo '<p>You could not add the order due to a system error. We apologize for any inconvenience.</p>';
            echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $query4 . '</p>';
            exit();
            header("Location: ./module/Supplier/productOrderManagement.php");
        }
    } else {
        echo "<hr>";
        echo '<h1 id="mainhead">Error!</h1>
        <p>The following error(s) occurred:<br />';
        echo "<div class='error'><ul>";
        foreach ($errors as $msg) { // Print each error.
            echo "<li>$msg</li>";
        }
        echo "</ul></div>";
        echo '</p><p>Please try again.</p><p><br /></p>';
    }
}
}
else {
    echo "Please Login";
}
?>
</div>
</div>
</body>
</html>
<!-- <?php  
include ('../../source/footer.php');
?> -->