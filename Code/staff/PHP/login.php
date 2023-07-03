<?php
// Establish database connection

include("../PHP/dataconnection.php");


// Retrieve the submitted staff ID and password from the form
$staffID = $_POST['staff-id'];
$password = $_POST['password'];

// Prepare and execute a query to retrieve the staff record based on the provided staff ID
$stmt = $connection->prepare("SELECT * FROM staff WHERE staff_id = ?");
$stmt->bind_param("i", $staffID);
$stmt->execute();

// Fetch the result
$result = $stmt->get_result();

// Check if a matching staff record was found and the entered password is correct
if ($result->num_rows === 1) {
  $row = $result->fetch_assoc();
  if (password_verify($password, $row['staff_pass'])) {
    // Redirect to the staff dashboard upon successful login
    header("Location: googledash.php");
    exit();
  }
}

// Display an error message if the login failed
echo "Invalid staff ID or password.";

// Close the prepared statement and database connection
$stmt->close();
$connection->close();
?>