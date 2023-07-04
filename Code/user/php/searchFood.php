<!DOCTYPE html>
<html>

<head>
    <title>Temp de Ventre</title>

    <script src="https://kit.fontawesome.com/fd65af94cc.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css" >
    <link rel="stylesheet" href="../css/navStyle.css">

</head>

<style>
    body{
        background-color: #ffffff;
        background-image: linear-gradient(315deg, #ffffff 0%, #d7e1ec 74%);       
    }

    .quantity-input{
        margin: 0 auto;
       width: 80px;
    }
</style>

<body>
    
<div class="profile">
        <a class="profile-link" href="../php/profile.php">
            <i class="fa-solid fa-user"></i>
            <p>User Profile</p>
        </a>
    </div>

    <form class="logout-form" action="../php/logout.php" method="POST">
        <i class="fa-solid fa-right-from-bracket"></i>
        <input type="submit" value="Logout">
    </form>
        

    <header>
        <nav id="navbar">
            <ul>
                <a href="../html/index.html" id="homeText" ><h1 >Temp de Ventre</h1></a>
                <li><a href="../html/index.html">Home</a></li>
                <li><a href="#">About Us</a></li>
                <li><a href="../html/specialty.html">Specialty</a></li>
                <li><a href="#">News</a></li>
                <li><a href="#">Contact Us</a></li>
            </ul>
        </nav>
    </header>
    
    <?php
    include("../php/dataconnection.php");

    // Process user input
    if (isset($_GET['keyword'])) {
        $keyword = $_GET['keyword'];

        // Prepare the SQL statement
        $sql = "SELECT * FROM product WHERE 
                product_type LIKE '%$keyword%' OR 
                product_name LIKE '%$keyword%' OR 
                product_ingredients LIKE '%$keyword%'";

        // Execute the query
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
            // Display the search results
            echo "<h2>Search Results:</h2>";
            while ($row = $result->fetch_assoc()) {
                echo '<div class="product text-center">';
                echo '<p class="product-type">Product Type: ' . $row['product_type'] . '</p>';
                echo '<p class="product-name">Product Name: ' . $row['product_name'] . '</p>';
                echo '<p class="product-ingredients">Product Ingredients: ' . $row['product_ingredients'] . '</p>';
                echo '<p class="product-price">Price: RM' . $row['price'] . '</p>';

                // Add to cart form
                echo '<form class="add-to-cart-form" action="addCart.php" method="POST">';
                echo '<input type="hidden" name="product_id" value="' . $row['product_id'] . '">';
                echo '<div class="form-group">';
                echo '<label for="quantity">Quantity:</label>';
                echo '<input type="number" class="form-control quantity-input" name="quantity" value="1" min="1" required>';
                echo '</div>';
                echo '<button type="submit" class="btn btn-primary">Add to Cart</button>';
                echo '</form>';

                echo '</div>';



                echo "<hr>";
            }
        } else {
            echo "<p>No results found.</p>";
        }

        // Close the database connection
        $connection->close();
    }
    ?>

    <form method="GET" action="">
        <input type="text" name="keyword" placeholder="Enter a keyword" required>
        <button type="submit">Search</button>
    </form>

</body>

</html>