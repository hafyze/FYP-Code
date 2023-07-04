<?php
// Include config file
require_once "dataconnection.php";
 
// Define variables and initialize with empty values
$product_name = $product_type = $product_ingredients = $price = "";
$name_err = $type_err = $ingredients_err = $price_err = "";

 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];

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
    $sql = "UPDATE product SET product_name=?, product_type=?, product_ingredients=?, price=? WHERE product_id=?";

    if($stmt = $connection->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("sssdi", $param_name, $param_type, $param_ingredients, $param_price, $param_id);
        // Set parameters
        $param_name = $product_name;
        $param_type = $product_type;
        $param_ingredients = $product_ingredients;
        $param_price = $price;
        $param_id = $id;
        
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
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id = trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM product WHERE product_id = ?";
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
                    $name = $row["product_name"];
                    $type = $row["product_type"];
                    $ingredients = $row["product_ingredients"];
					$price = $row["price"];
					$id = $row["product_id"];
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
    <title>Update Product Info</title>
</head>
<body>
<div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Update Product Information</h2>
                    <p>Please fill this form and submit to add prodcut to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["REQUEST_URI"]); ?>" method="post">
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
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="productindex.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>