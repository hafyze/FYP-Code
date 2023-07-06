<?php
// Include config file
require_once "dataconnection.php";
 
// Define variables and initialize with empty values
$promo_condition = $discount = $starting_date = $end_date = "";
$condition_err = $discount_err = $start_err = $end_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate condition
    $input_condition = trim($_POST["promo_condition"]);
    if(empty($input_condition)){
        $condition_err = "Please enter the condition.";
    } else{
        $promo_condition = $input_condition;
    }
    
	//validate discount
	$input_discount = trim($_POST["discount"]);
	if(empty($input_discount)){
		$discount_err = "Please enter a discount.";
	} else{
		$discount = $input_discount;
	}
	 
     // Validate start date
    $input_start = trim($_POST["starting_date"]);
    if(empty($input_start)){
        $start_err = "Please input start date.";  
    } else{
        $starting_date = $input_start;
    }
	
    // Validate end date
    $input_end = trim($_POST["end_date"]);
    if(empty($input_end)){
        $end_err = "Please input end date.";  
    } else{
        $end_date = $input_end;
    }
    
    // Check input errors before inserting in database
    if(empty($condition_err) && empty($discount_err) && empty($start_err)&& empty($end_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO promotion(promo_condition, discount, starting_date, end_date) VALUES (?, ?, ?, ?)";
 
        if($stmt = $connection->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("iiss", $param_condition, $param_discount, $param_start_date, $param_end_date);
            // Set parameters
            $param_condition = $promo_condition;
            $param_discount = $discount;
			$param_start_date = $starting_date;
            $param_end_date = $end_date;
            
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
}
?>
 
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register New Promotion Information</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
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
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Promotion</h2>
                    <p>Please fill this form and submit to add prodcut to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Condition</label>
                            <input type="number" name="promo_condition" class="form-control <?php echo (!empty($condition_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $promo_condition; ?>">
                            <span class="invalid-feedback"><?php echo $condition_err;?></span>
                        </div>
						<div class="form-group">
                            <label>Discount</label>
                            <input type="number" name="discount" class="form-control <?php echo (!empty($discount_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $discount; ?>">
                            <span class="invalid-feedback"><?php echo $discount_err;?></span>
                        </div>
					    <div class="form-group">
                            <label>Start Date</label>
                            <input type="date" name="starting_date" class="form-control <?php echo (!empty($start_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $starting_date; ?>">
                            <span class="invalid-feedback"><?php echo $start_err;?></span>
                        </div>
						<div class="form-group">
                            <label>End Date</label>
                            <input type="date" name="end_date" class="form-control <?php echo (!empty($end_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $end_date; ?>">
                            <span class="invalid-feedback"><?php echo $end_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="promotionindex.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>