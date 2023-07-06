<!DOCTYPE html>
<html>

<head>
    <title>Temps de Ventre</title>

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

    .add-to-cart-button {
        padding: 5px 10px;
        background-color: #337ab7;
        color: #fff;
        border: none;
        border-radius: 10px;
        cursor: pointer;
    }

    .add-to-cart-button:hover {
        background-color: #23527c;
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
                <th></th> <!-- Add column for "Add to Cart" button -->
            </tr>
            <?php 
            include("../php/dataconnection.php");

            $sql = "SELECT * FROM product";
            $result = $connection->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $productId = $row['product_id'];
                    $productName = $row['product_name'];
                    $productIngredient = $row['product_ingredients'];
                    $price = $row['price'];

                    echo "<tr>";
                    echo "<td>$productName</td>";
                    echo "<td>$productIngredient</td>";
                    echo "<td>$price</td>";
                    echo "<td>";
                    echo "<button class='add-to-cart-button' onclick='addToCart($productId)'>Add to Cart</button>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No products available.</td></tr>";
            }
            ?>
        </table>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        // Function to add a product to the cart
        function addToCart(productId) {
            // Prompt the user to enter the quantity
            var quantity = prompt("Enter the quantity:");

            // Validate the quantity
            if (quantity !== null && quantity !== "") {
                // Send an AJAX request to addCart.php to process the addition to cart
                $.ajax({
                    url: "../php/addCart.php",
                    type: "POST",
                    data: {
                        product_id: productId,
                        quantity: quantity
                    },
                    success: function(response) {
                        alert("Successfully added product to cart.");
                        location.reload();
                    },
                    error: function() {
                        alert("Error adding product to cart.");
                    }
                });
            }
        }
    </script>
</body>

</html>
