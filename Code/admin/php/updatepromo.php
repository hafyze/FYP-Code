<?php
// Include config file
require_once "dataconnection.php";
 
// Define variables and initialize with empty values
$discount = $start = $end = $condition = "";
$discount_err = $start_err = $end_err = $condition_err = "";

 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];

// Validate type
$input_discount = trim($_POST["discount"]);
if(empty($input_discount)){
    $discount_err = "Please enter discount.";
} else{
    $discount = $input_discount;
}

      // Validate fee
$input_start = trim($_POST["starting_date"]);
if(empty($input_start)){
    $start_err = "Please input starting date.";  
} else{
    $start = $input_start;
}
 
 //validate ingredients
 $input_end = trim($_POST["end_date"]);
if(empty($input_end)){
    $end_err = "Please enter cart end date.";
} else{
    $end = $input_end;
}

// Validate email
$input_condition = trim($_POST["promo_condition"]);
if(empty($input_condition)){
    $condition_err = "Please enter a condition.";  
} else{
    $condition = $input_condition;
}
    
// Check input errors before inserting in database
if(empty($discount_err) && empty($start_err)&& empty($end_err)&& empty($condition_err)){
    // Prepare an insert statement
    $sql = "UPDATE promotion SET discount=?, starting_date=?, end_date=?, promo_condition=? WHERE promo_id=?";

    if($stmt = $connection->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("isssi", $param_discount, $param_start, $param_end, $param_condition, $param_id);
        // Set parameters
        $param_discount = $discount;
        $param_start = $start;
        $param_end = $end;
        $param_condition = $condition;
        $param_id = $id;
        
        // Attempt to execute the prepared statement
        if($stmt->execute()){
            // Records created successfully. Redirect to landing page
            echo "<script>alert('Product created successfully');document.location='promotionindex.php'</script>";
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
        $sql = "SELECT * FROM promotion WHERE promo_id = ?";
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
                    $discount = $row["discount"];
                    $start = $row["starting_date"];
                    $end = $row["end_date"];
					$condition = $row["promo_condition"];
					$id = $row["promo_id"];
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
    <title>Update Promotion Info</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{
            font-family: "Lato", sans-serif;
            background-color: #ffffff;
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
                    <h2 class="mt-5">Update Promotion Information</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["REQUEST_URI"]); ?>" method="post">
						<div class="form-group">
                            <label>Discount</label>
                            <input type="number" name="discount" class="form-control <?php echo (!empty($discount_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $discount; ?>">
                            <span class="invalid-feedback"><?php echo $discount_err;?></span>
                        </div>
					    <div class="form-group">
                            <label>Start Date</label>
                            <input type="date" name="starting_date" class="form-control <?php echo (!empty($start_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $start; ?>">
                            <span class="invalid-feedback"><?php echo $start_err;?></span>
                        </div>
						<div class="form-group">
                            <label>End Date</label>
                            <input type="date" name="end_date" class="form-control <?php echo (!empty($end_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $end; ?>">
                            <span class="invalid-feedback"><?php echo $end_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Condition</label>
                            <input type="number" name="promo_condition" class="form-control <?php echo (!empty($condition_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $condition; ?>">
                            <span class="invalid-feedback"><?php echo $condition_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="promotionindex.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
</body>
</html>