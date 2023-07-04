<?php
include("../php/dataconnection.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the form data
    $staffID = $_POST["staffID"];
    $action = $_POST["action"]; // "checkin" or "checkout"
    $currentTime = date("Y-m-d H:i:s");

    // Insert the attendance record into the database
    $insertQuery = "INSERT INTO staff_attendance (staff_id, checkin_time, checkout_time) 
                    VALUES (?, ?, NULL)";
    $insertStmt = mysqli_prepare($connection, $insertQuery);

    if ($action == "checkin") {
        // Perform check-in action
        mysqli_stmt_bind_param($insertStmt, "is", $staffID, $currentTime);
    } elseif ($action == "checkout") {
        // Perform check-out action
        $updateQuery = "UPDATE staff_attendance SET checkout_time = ? WHERE staff_id = ? AND checkout_time IS NULL";
        $updateStmt = mysqli_prepare($connection, $updateQuery);

        mysqli_stmt_bind_param($updateStmt, "si", $currentTime, $staffID);
        mysqli_stmt_execute($updateStmt);
    }

    // Execute the check-in or check-out query
    mysqli_stmt_execute($insertStmt);

    if (mysqli_stmt_affected_rows($insertStmt) > 0 || mysqli_stmt_affected_rows($updateStmt) > 0) {
        // Check-in or check-out successful
        // You can perform any additional actions here or display a success message
        echo "<p>Attendance record updated successfully.</p>";
    } else {
        // Check-in or check-out failed
        // Handle the failure case or display an error message
        echo "<p>Attendance record update failed.</p>";
    }

    // Close the prepared statements
    mysqli_stmt_close($insertStmt);
    mysqli_stmt_close($updateStmt);
}
?>

<!-- HTML form in attendance.php -->
<h2>Staff Attendance</h2>

<form action="../php/attendance.php" method="POST">
    <div class="form-group">
        <label for="staffID">Staff ID:</label>
        <input type="text" id="staffID" name="staffID" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="action">Action:</label>
        <select id="action" name="action" class="form-control" required>
            <option value="checkin">Check-in</option>
            <option value="checkout">Check-out</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>