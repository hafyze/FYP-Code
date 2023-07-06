<?php
// Include config file
require_once "dataconnection.php";

//option select for admin
$queryadmin = "SELECT * FROM admin";
$resultadmin = mysqli_query($connection,$queryadmin);
 
// Define variables and initialize with empty values
$staff_name = $staff_contact = $staff_email = $staff_role = $staff_pass = $admin_id = "";
$name_err = $contact_err = $email_err = $role_err = $pass_err = $admin_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate name
    $input_name = trim($_POST["staff_name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } else{
        $staff_name = $input_name;
    }
    
	// Validate contact
    $input_contact = trim($_POST["staff_contact"]);
    if(empty($input_contact)){
        $contact_err = "Please enter a Phone Number.";  
	} elseif(preg_match('/^[0-9]{10}+$/', $staff_contact)){
        $contact_err = "Please enter a valid phone number.";
    } else{
        $staff_contact = $input_contact;
    }
	 
    // Validate email
    $input_email = trim($_POST["staff_email"]);
    if(empty($input_email)){
        $email_err = "Please enter an email adress.";  
    } elseif (!filter_var($input_email, FILTER_VALIDATE_EMAIL)) {
        $email_err = "Invalid email format";	
    } else{
        $staff_email = $input_email;
    }

	// Validate role
    $input_role = trim($_POST["staff_role"]);
    if(empty($input_role)){
        $role_err = "Please select a name.";
    } else{
        $staff_role = $input_role;
    }

	//validate pass
	$input_password = trim($_POST["staff_pass"]);
    if(empty($input_password)){
        $pass_err = "Please enter a password.";
    } else{
        $staff_pass = ($input_password);
    }

    // Validate admin
    $input_admin = trim($_POST["admin_id"]);
    if(empty($input_admin)){
        $admin_err = "Please select an Admin.";     
    } else{
        $admin_id = $input_admin;
    }
    
	
    // Check input errors before inserting in database
    if(empty($name_err) && empty($contact_err) && empty($email_err)&& empty($role_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO staff(staff_name, staff_contact, staff_email, staff_role, staff_pass, admin_id) VALUES (?, ?, ?, ?, ?, ?)";
 
        if($stmt = $connection->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sssssi", $param_name, $param_contact, $param_email, $param_role, $param_pass, $param_admin);
            // Set parameters
            $param_name = $staff_name;
            $param_contact = $staff_contact;
			$param_email = $staff_email;
            $param_role = $staff_role;
			$param_pass = $staff_pass;
            $param_admin = $admin_id;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records created successfully. Redirect to landing page
				echo "<script>alert('Product created successfully');document.location='insertstaff.php'</script>";
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
    <title>Register New Staff Information</title>
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
                    <h2 class="mt-5">Staff</h2>
                    <p>Please fill this form and submit to add staff to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="staff_name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $staff_name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
						<div class="form-group">
                            <label>Phone Number</label>
                            <input type="number" name="staff_contact" class="form-control <?php echo (!empty($contact_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $staff_contact; ?>">
                            <span class="invalid-feedback"><?php echo $contact_err;?></span>
                        </div>
					    <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="staff_email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $staff_email; ?>">
                            <span class="invalid-feedback"><?php echo $email_err;?></span>
                        </div>
						<div class="form-group">
                            <label>Role</label>
									<select name="staff_role">
									<option value=Chef >Chef</option>
									<option value=Delivery >Delivery</option>
									<option value=Customer_Service >Customer Service</option>
									</select>
									<span class="invalid-feedback"><?php echo $role_err;?></span>
                        </div>
						<div class="form-group mb-3">
                                <label>Password</label>
                                <input required type="password" id="staff_pass" name="staff_pass" placeholder="Enter your password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Admin</label>
									<select name="admin_id">
									<?php while($row1= mysqli_fetch_array($resultadmin)):;?>
									<option value="<?php echo $row1[0]?>"><?php echo $row1[0];?></option>
									<?php endwhile;?>
									</select>
									<span class="invalid-feedback"><?php echo $admin_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="insertstaff.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>