<!DOCTYPE html>
<html>

<head>
    <title>Temp de Ventre</title>

    <script src="https://kit.fontawesome.com/fd65af94cc.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css" <?php echo time()?>>
    <link rel="stylesheet" href="../css/specialty.css"<?php echo time()?>>

</head>

<style>
    table {
            margin: 0 auto;
    }
        
    th, td 
    {
        padding: 2px 5px;
        text-align: center;
        margin: 5px;
    }
</style>

<?php 
    include("../php/dataconnection.php");

    $sql = "SELECT * FROM product";
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Food Category</th><th>Food</th><th>Main Ingredient</th><th>Price</th></tr>";
    
        while ($row = $result->fetch_assoc()) {
            $productType = $row['product_type'];
            $productName = $row['product_name'];
            $productIngredient = $row['product_ingredients'];
            $price = $row['price'];
    
            echo "<tr>";
            echo "<td>$productType</td>";
            echo "<td>$productName</td>";
            echo "<td>$productIngredient</td>";
            echo "<td>$price</td>";
            echo "</tr>";
        }
    
        echo "</table>";
    } else {
        echo "No products available.";
    }
?>
</html>