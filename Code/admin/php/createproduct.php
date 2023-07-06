<?php
// Include config file
require_once "dataconnection.php";
 
// Define variables and initialize with empty values
$product_name = $product_type = $product_ingredients = $price = "";
$name_err = $type_err = $ingredients_err = $price_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate name
    $input_product = trim($_POST["product"]);
    if(empty($input_product)){
        $name_err = "Please enter a name.";
    } else{
        $product_name = $input_product;
    }
    
		  // Validate type
    $input_type = trim($_POST["type"]);
    if(empty($input_type)){
        $type_err = "Please input a type.";  
    } else{
        $product_type = $input_type;
    }
	 
     //validate ingredients
	 $input_ingredients = trim($_POST["ingredients"]);
    if(empty($input_ingredients)){
        $ingredients_err = "Please enter ingredients.";
    } else{
        $product_ingredients = $input_ingredients;
    }
	
    // Validate email
    $input_price = trim($_POST["price"]);
    if(empty($input_price)){
        $price_err = "Please enter an email adress.";  
    } else{
        $price = $input_price;
    }
    
	
    // Check input errors before inserting in database
    if(empty($name_err) && empty($type_err) && empty($ingredients_err)&& empty($price_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO product(product_name, product_type, product_ingredients, price) VALUES (?, ?, ?, ?)";
 
        if($stmt = $connection->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sssd", $param_name, $param_type, $param_ingredients, $param_price);
            // Set parameters
            $param_name = $product_name;
            $param_type = $product_type;
			$param_ingredients = $product_ingredients;
            $param_price = $price;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records created successfully. Redirect to landing page
				echo "<script>alert('Product created successfully');document.location='productindex.php'</script>";
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
    <title>Register New Product Information</title>
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
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Product</h2>
                    <p>Please fill this form and submit to add prodcut to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="product" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $product_name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
						<div class="form-group">
                            <label>Product Type</label>
                            <input type="text" name="type" class= form-control <?php echo (!empty($type_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $product_type; ?>">
                            <span class="invalid-feedback"><?php echo $type_err;?></span>
                        </div>
					    <div class="form-group mb-3">
                            <label>Ingredients</label>
                            <input type="text" name="ingredients" class= form-control <?php echo (!empty($ingredients_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $product_ingredients; ?>">
                            <span class="invalid-feedback"><?php echo $ingredients_err;?></span>
                        </div>
						<div class="form-group">
                            <label>Price</label>
                            <input type="number" min="0.00" max="10000.00" step="0.01" name="price" class="form-control <?php echo (!empty($price_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $price; ?>">
                            <span class="invalid-feedback"><?php echo $price_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="productindex.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>