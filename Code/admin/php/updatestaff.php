<?php
// Include config file
require_once "dataconnection.php";

//option select for admin
$queryadmin = "SELECT * FROM admin";
$resultadmin = mysqli_query($connection,$queryadmin);
 
// Define variables and initialize with empty values
$name = $contact = $email = $role = $pass = $admin = "";
$name_err = $contact_err = $email_err = $role_err = $pass_err = $admin_err = "";

 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];

// Validate name
$input_name = trim($_POST["staff_name"]);
if(empty($input_name)){
    $name_err = "Please enter staff name.";
} else{
    $name = $input_name;
}

      // Validate contact
$input_contact = trim($_POST["staff_contact"]);
if(empty($input_contact)){
    $contact_err = "Please input staff contact.";
}elseif(preg_match('/^[0-9]{10}+$/', $contact)){
    $contact_err = "Please enter a valid phone number.";
} else{
    $contact = $input_contact;
}
 
 //validate email
 $input_email = trim($_POST["staff_email"]);
 if(empty($input_email)){
    $email_err = "Please enter staff email adress.";  
} elseif (!filter_var($input_email, FILTER_VALIDATE_EMAIL)) {
    $email_err = "Invalid email format";	
} else{
    $email = $input_email;
}

// Validate role
$input_role = trim($_POST["staff_role"]);
if(empty($input_role)){
    $role_err = "Please enter a role.";  
} else{
    $role = $input_role;
}

// Validate pass
$input_pass = trim($_POST["staff_pass"]);
if(empty($input_pass)){
    $role_err = "Please enter password.";  
} else{
    $pass = $input_pass;
}

// Validate admin id
$input_admin = trim($_POST["admin_id"]);
if(empty($input_admin)){
    $admin_err = "Please enter a condition.";  
} else{
    $admin = $input_admin;
}
    
// Check input errors before inserting in database
if(empty($name_err) && empty($contact_err)&& empty($email_err)&& empty($admin_err)&& empty($pass_err)&& empty($role)){
    // Prepare an insert statement
    $sql = "UPDATE staff SET staff_name=?, staff_contact=?, admin_id=?, staff_role=?, staff_pass=? WHERE staff_id=?";

    if($stmt = $connection->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("sssisii", $param_name, $param_contact, $param_email, $param_admin, $param_role, $param_id, $param_pass);
        // Set parameters
        $param_name = $name;
        $param_contact = $contact;
        $param_email = $email;
        $param_role = $role;
        $param_pass = $pass;
        $param_admin = $admin;
        $param_id = $id;
        
        // Attempt to execute the prepared statement
        if($stmt->execute()){
            // Records created successfully. Redirect to landing page
            echo "<script>alert('Staff updated successfully');document.location='insertstaff.php'</script>";
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
        $sql = "SELECT * FROM staff WHERE staff_id = ?";
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
                    $name = $row["staff_name"];
                    $contact = $row["staff_contact"];
                    $email = $row["staff_email"];
					$role = $row["staff_role"];
                    $pass = $row["staff_pass"];
                    $admin = $row["admin_id"];
					$id = $row["staff_id"];
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
    <title>Update Staff Info</title>
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
                    <h2 class="mt-5">Update Staff Information</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["REQUEST_URI"]); ?>" method="post">
                    <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="staff_name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
						<div class="form-group">
                            <label>Phone Number</label>
                            <input type="number" name="staff_contact" class="form-control <?php echo (!empty($contact_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $contact; ?>">
                            <span class="invalid-feedback"><?php echo $contact_err;?></span>
                        </div>
					    <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="staff_email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
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
                                <input required type="password" id="staff_pass" name="staff_pass" placeholder="Enter your password" class="form-control" >
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
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" name="updateStaff" class="btn btn-primary" value="Submit">
                        <a href="insertstaff.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
</body>
</html>

<?php
include("../php/dataconnection.php");


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the staff ID from the form
    $staffID = $_POST["id"];

    // Retrieve the form data
    $name = $_POST["staff_name"];
    $contact = $_POST["staff_contact"];
    $email = $_POST["staff_email"];
    $role = $_POST["staff_role"];
    $pass = $_POST["staff_pass"];
    $adminID = $_POST["admin_id"];

    // Prepare the update statement
    $query = "UPDATE staff SET 
                staff_name = '$name', 
                staff_contact = '$contact', 
                staff_email = '$email',
                staff_role = '$role',
                staff_pass = '$pass',
                admin_id = '$adminID'
                WHERE staff_id = $staffID";
    
    // Execute the update statement
    if (mysqli_query($connection, $query)) {
        
        // Update successful
        echo "<script>alert('Staff information updated successfully'); document.location='insertstaff.php';</script>";
        exit();
    } else {
        // Update failed
        echo "Error updating staff information: " . mysqli_error($connection);
    }

    // Close the database connection
    mysqli_close($connection);
}
?>