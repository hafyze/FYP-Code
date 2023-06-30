<!DOCTYPE html>
<html>

<head>
    <title>Temp de Ventre</title>

    <script src="https://kit.fontawesome.com/fd65af94cc.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../css/specialty.css?v=<?php echo time(); ?>">
</head>

<style>
    table {
        margin: 0 auto;
    }
        
    th, td {
        padding: 10px;
        text-align: center;
    }

    .menu-container {
        width: 80%;
        margin: 0 auto;
    }

    .menu-header {
        text-align: center;
        margin-bottom: 20px;
    }

    .menu-header h2 {
        font-size: 24px;
        font-weight: bold;
    }

    .menu-table {
        width: 100%;
        border-collapse: collapse;
    }

    .menu-table th,
    .menu-table td {
        padding: 10px;
        border-bottom: 1px solid #ccc;
    }

    .menu-table th {
        background-color: #f8f8f8;
    }
</style>

<body>
    <div class="menu-container">
        <div class="menu-header">
            <h2>Menu</h2>
        </div>

        <table class="menu-table">
            <tr>
                <th>Food</th>
                <th>Main Ingredient</th>
                <th>Price</th>
            </tr>
            <?php 
            include("../php/dataconnection.php");

            $sql = "SELECT * FROM product";
            $result = $connection->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $productName = $row['product_name'];
                    $productIngredient = $row['product_ingredients'];
                    $price = $row['price'];

                    echo "<tr>";
                    echo "<td>$productName</td>";
                    echo "<td>$productIngredient</td>";
                    echo "<td>$price</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No products available.</td></tr>";
            }
            ?>
        </table>
    </div>
</body>

</html>
