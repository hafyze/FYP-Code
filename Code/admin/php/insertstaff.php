<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Staff Management</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        body{
            font-family: "Lato", sans-serif;
            background-color: #ffffff;
            background-image: linear-gradient(315deg, #ffffff 0%, #d7e1ec 74%);
        }
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
        table tr td:last-child{
            width: 120px;
        }
        h2{
        font-family: 'Dancing Script', cursive;
        }
    </style>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">Staff Details</h2>
                        <a href="addstaff.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Register New Staff</a>
                    </div>
                    
					<?php
                    // Include config file
                    require_once "dataconnection.php";
                    
                    // Attempt select query execution
                    $sql = "SELECT * FROM staff";
                    if($result = $connection->query($sql)){
                        if($result->num_rows > 0){
                            echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>ID</th>";
                                        echo "<th>Name</th>";
                                        echo "<th>Contact</th>";
                                        echo "<th>Email</th>";
                                        echo "<th>Role</th>";
										echo "<th>Password</th>";
										echo "<th>Admin ID</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = $result->fetch_array()){
													
                                    echo "<tr>";
                                        echo "<td>" . $row['staff_id'] . "</td>";
                                        echo "<td>" . $row['staff_name'] . "</td>";
                                        echo "<td>" . $row['staff_contact'] . "</td>";
                                        echo "<td>" . $row['staff_email'] . "</td>";
										echo "<td>" . $row['staff_role'] . "</td>";
										echo "<td>" . $row['staff_pass'] . "</td>";
										echo "<td>" . $row['admin_id'] . "</td>";
                                        echo "<td>";
                                         //   echo '<a href="readSinger.php?id='. $row['singer_ID'] .'">Reada</a>';
                                            echo '<a href="updatestaff.php?id='. $row['staff_id'] .'" class="btn btn-primary ml-2">UPDATE</a>';
                                            echo '<a href="deletestaff.php?id='. $row['staff_id'] .'" class="btn btn-secondary ml-2">DELETE</a>';
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            $result->free();
                        } else{
                            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                        }
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }
                    
                    // Close connection
                    $connection->close();
                    ?>
					<a href="Adminindex.php" class="btn btn-secondary ml-2">Back to Main Menu</a>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>