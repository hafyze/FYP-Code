<!DOCTYPE html>
<html>
<head>
  <title>Administrator</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    body {
      font-family: "Lato", sans-serif;
      background-color: #ffffff;
      margin: 0;
      padding: 0;
    }
    
    /* Fixed sidenav, full height */
    .sidenav {
      height: 100vh;
      width: 200px;
      position: fixed;
      z-index: 1;
      top: 0;
      left: 0;
      background-color: #657566;
      overflow-x: hidden;
      padding-top: 20px;
    }
    
    /* Style the sidenav links and the dropdown button */
    .sidenav a {
      padding: 8px 16px;
      text-decoration: none;
      font-size: 20px;
      color: #A9A9A9;
      display: block;
      border: none;
      background: none;
      width: 100%;
      text-align: left;
      cursor: pointer;
      outline: none;
    }
    
    /* On mouse-over */
    .sidenav a:hover {
      color: #f1f1f1;
    }
    
    /* Main content */
    .main {
      margin-left: 200px; /* Same as the width of the sidenav */
      font-size: 20px; /* Increased text to enable scrolling */
      padding: 20px;
    }
    
    h2 {
      margin-top: 0;
    }
  </style>
</head>
<body>

<div class="sidenav">
  <a href="insertstaff.php">Staff Management</a>
  <a href="customerindex.php">Customer</a>
  <a href="productindex.php">Product List</a>
  <a href="promotionindex.php">Promotion</a>
  <a href="paymentindex.php">View Payment</a>
  <a href="logout.php">Logout</a>
</div>

<div class="main">
  <h2>Administration Interface</h2>
  <p>Welcome back</p>
</div>

</body>
</html>