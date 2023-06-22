<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" href="../css/admin.css">
    <link rel="stylesheet" type="text/css" href="../css/mobile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Poppins:wght@300&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
    <script src="js/index.js"></script>
    <script>
        
        function totalPrice(){
            let date = "<?php ?>";
        }

    </script>
</head>

<body>
    <header>
        <h2>Temps De Ventre</h2>
    </header>



    <div class="main">
        <div id="admindash">
            <h1><i class="fa-solid fa-user"></i>Admin Dashboard</h1>
            <h2>Orders</h2>
            <div class="service">
                <h2>Insert New Order</h2>

                <form class="addroom" name="addfrm" method="post" action="../php/add_order.php">
                    <p>
                        <label for="product_name">Product Name: </label>
                        <input type="text" name="product_name" size="80"></p>
                    <p>
                        <label for="product_type">Product Type:</label>
                        <input type="text" name="product_type"></p>
                    <p>
                    <p>
                        <label for="product_ingredients">Product Ingredients:</label>
                        <input type="text" name="product_ingredients"></p>
                        <p>
                        <label for="product_price">Room Price (RM):</label>
                        <input class="user_input" type="number" name="product_price" size="10"></p>
                    <p>
                    <p>
                        <input type="submit" name="savebtn" value="Save Order">
                    </p>
                   
                </form>
            </div>
        </div>
    </div>
</body>

</html>

<?php
    $connection = new mysqli("localhost", "root", "", "hotel");
    //echo "Connection successful";

    $roomName = $_POST["room_name"];
    $checkIn = $_POST["date_in"];
    $checkOut = $_POST["date_out"];
    $room_price = $_POST["room_price"];
    $format = "d/m/Y";

    if($connection->connect_error){
        die("Connection failed: " . $connection->connect_error);
    }else{

        $date_in = new DateTime($checkIn);
        $date_out = new DateTime( $checkOut);
        $day_interval = $date_in->diff($date_out);
        $total_days = $day_interval->days;
        $totalPrice = $room_price * $total_days;
        $sql = $connection->prepare("INSERT INTO room_order(room_name, date_in, date_out, total_price)
                VALUES(?, ?, ?,?)");
        $sql->bind_param("sssi", $roomName, $checkIn, $checkOut, $totalPrice);
        $sql->execute();
        //echo "Registration successul";
        $sql->close();
        $connection->close();
    }

    header("Location: view_order.php");
?>