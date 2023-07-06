<?php
// Include config file
require_once "dataconnection.php";
 
// Define variables and initialize with empty values
$type = $fee = $cart = $address = $status = "";
$type_err = $fee_err = $cart_err = $address_err = $status_err = "";

 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];

// Validate type
$input_type = trim($_POST["payment_type"]);
if(empty($input_type)){
    $type_err = "Please enter a type.";
} else{
    $type = $input_type;
}

      // Validate fee
$input_fee = trim($_POST["fee"]);
if(empty($input_fee)){
    $fee_err = "Please input fee.";  
} else{
    $fee = $input_fee;
}
 
 //validate ingredients
 $input_cart = trim($_POST["cart_id"]);
if(empty($input_cart)){
    $cart_err = "Please enter cart id.";
} else{
    $cart = $input_cart;
}

// Validate email
$input_address = trim($_POST["customer_address"]);
if(empty($input_address)){
    $address_err = "Please enter an adress.";  
} else{
    $address = $input_address;
}

// Validate role
$input_status = trim($_POST["payment_status"]);
if(empty($input_status)){
    $status_err = "Please select current status.";
} else{
    $status = $input_status;
}
    
// Check input errors before inserting in database
if(empty($type_err) && empty($fee_err) && empty($cart_err)&& empty($address_err)&& empty($status_err)){
    // Prepare an insert statement
    $sql = "UPDATE payment SET payment_type=?, fee=?, cart_id=?, customer_address=?, payment_status=? WHERE payment_id=?";

    if($stmt = $connection->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("sdissi", $param_type, $param_fee, $param_cart, $param_address, $param_status, $param_id);
        // Set parameters
        $param_type = $type;
        $param_fee = $fee;
        $param_cart = $cart;
        $param_address = $address;
        $param_status = $status;
        $param_id = $id;
        
        // Attempt to execute the prepared statement
        if($stmt->execute()){
            // Records created successfully. Redirect to landing page
            echo "<script>alert('Payment updated successfully');document.location='paymentindex.php'</script>";
           // header("location: singerIndex.php");
            exit();
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
    // Close statement
    $stmt->close();
}

// Close connection
$connection->close();
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id = trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM payment WHERE payment_id = ?";
        if($stmt = $connection->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("i", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                $result = $stmt->get_result();
                
                if($result->num_rows == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = $result->fetch_array(MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $type = $row["payment_type"];
                    $fee = $row["fee"];
                    $cart = $row["cart_id"];
					$address = $row["customer_address"];
                    $status = $row["payment_status"];
					$id = $row["payment_id"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        $stmt->close();
        
        // Close connection
        $connection->close();
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
 
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Payment Info</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{
            font-family: "Lato", sans-serif;
            background-color: #ffffff;
            background-image: linear-gradient(315deg, #ffffff 0%, #d7e1ec 74%);
        }
        .wrapper{
            width: 600px;
            margin: 0 auto;
            margin-top: 50px;
        }
        .invalid-feedback {
            display: block;
            color: red;
        }
        h2{
        font-family: 'Dancing Script', cursive;
        }
    </style>
</head>
<body>
<div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Update Payment Information</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["REQUEST_URI"]); ?>" method="post">
                    <div class="form-group">
                            <label>Select Payment Method</label>
									<select name="payment_type">
									<option value=Cash >Cash</option>
									<option value=Card >Card</option>
									<option value=Bank_Transfer >Bank Transfer</option>
                                    <option value=QR_Code >QR Code</option>
									</select>
									<span class="invalid-feedback"><?php echo $type_err;?></span>
                        </div>
						<div class="form-group">
                            <label>Fee</label>
                            <input type="number" min="0.00" max="10000.00" step="0.01" name="fee" class="form-control <?php echo (!empty($fee_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $fee; ?>">
                            <span class="invalid-feedback"><?php echo $fee_err;?></span>
                        </div>
						<div class="form-group">
                            <label>Cart_ID</label>
                            <input type="number" name="cart_id" class="form-control <?php echo (!empty($cart_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $cart; ?>">
                            <span class="invalid-feedback"><?php echo $cart_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Insert Customer Address</label>
                            <input type="text" name="customer_address" class="form-control <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $address; ?>">
                            <span class="invalid-feedback"><?php echo $address_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
									<select name="payment_status">
									<option value=Pending >Pending</option>
									<option value=Verified >Verified</option>
									</select>
									<span class="invalid-feedback"><?php echo $status_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="paymentindex.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>