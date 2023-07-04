<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product Management</title>
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
                        <h2 class="pull-left">Product Details</h2>
                        <a href="createproduct.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New Product</a>
                    </div>
                    
					<?php
                    // Include config file
                    require_once "dataconnection.php";
                    
                    // Attempt select query execution
                    $sql = "SELECT * FROM product";
                    if($result = $connection->query($sql)){
                        if($result->num_rows > 0){
                            echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>ID</th>";
                                        echo "<th>Name</th>";
                                        echo "<th>Type</th>";
                                        echo "<th>Ingredients</th>";
                                        echo "<th>Price</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = $result->fetch_array()){
													
                                    echo "<tr>";
                                        echo "<td>" . $row['product_id'] . "</td>";
                                        echo "<td>" . $row['product_name'] . "</td>";
                                        echo "<td>" . $row['product_type'] . "</td>";
                                        echo "<td>" . $row['product_ingredients'] . "</td>";
										echo "<td>" . $row['price'] . "</td>";
                                        echo "<td>";
                                         //   echo '<a href="readSinger.php?id='. $row['singer_ID'] .'">Reada</a>';
                                            echo '<a href="updateproduct.php?id='. $row['product_id'] .'" class="btn btn-primary ml-2">UPDATE</a>';
                                            echo '<a href="deleteproduct.php?id='. $row['product_id'] .'" class="btn btn-secondary ml-2">DELETE</a>';
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