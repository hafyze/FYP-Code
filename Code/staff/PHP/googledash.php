<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Staff Dashboard</title>
  <style>
    /* Reset default browser styles */
    body, h1, ul, li {
      margin: 0;
      padding: 0;
    }

    body {
      font-family: Arial, sans-serif;
    }

    /* Header styles */
    header {
      background-color: #333;
      color: #fff;
      padding: 20px;
    }

    h1 {
      font-size: 24px;
    }

    /* Sidebar styles */
    .sidebar {
      background-color: #f2f2f2;
      width: 250px;
      padding: 20px;
      float: left;
    }

    ul {
      list-style-type: none;
      padding: 0;
    }

    li {
      margin-bottom: 10px;
    }

    a {
      color: #333;
      text-decoration: none;
    }

    /* Main content styles */
    .content {
      padding: 20px;
      margin-left: 270px;
    }

    /* Footer styles */
    footer {
      background-color: #333;
      color: #fff;
      padding: 10px;
      clear: both;
    }

    /* Delivery features */
    .delivery-section {
      margin-top: 20px;
    }

    .delivery-card {
      border: 1px solid #ccc;
      border-radius: 5px;
      padding: 10px;
      margin-bottom: 10px;
    }

    .delivery-card .title {
      font-weight: bold;
      margin-bottom: 5px;
    }

    .delivery-card .description {
      color: #777;
    }

    .delivery-card .status {
      margin-top: 5px;
    }

    .delivery-card .status span {
      font-weight: bold;
    }

    .delivery-card .status .delivered {
      color: green;
    }

    .delivery-card .status .pending {
      color: orange;
    }

    /* Check-in/out features */
    .check-in-out-section {
      margin-top: 20px;
    }

    .check-in-out-card {
      border: 1px solid #ccc;
      border-radius: 5px;
      padding: 10px;
      margin-bottom: 10px;
    }

    .check-in-out-card .title {
      font-weight: bold;
      margin-bottom: 5px;
    }

    .check-in-out-card .timestamp {
      color: #777;
    }

    .check-in-out-card .check-button {
      margin-top: 5px;
    }
    
    /* Google Maps iframe styles */
    .google-map {
      margin-top: 10px;
    }
  </style>
  <script>
     function checkIn() {
      var checkInCard = document.getElementById("check-in-card");
      var timestamp = new Date().toLocaleString();
      checkInCard.innerHTML = `
        <div class="title">Check-in</div>
        <div class="timestamp">Timestamp: ${timestamp}</div>
      `;
    }

    function checkOut() {
      var checkOutCard = document.getElementById("check-out-card");
      var timestamp = new Date().toLocaleString();
      checkOutCard.innerHTML = `
        <div class="title">Check-out</div>
        <div class="timestamp">Timestamp: ${timestamp}</div>
      `;
    }
    
    function changeDeliveryStatus(cardId, newStatus) {
      var deliveryCard = document.getElementById(cardId);
      var statusElement = deliveryCard.querySelector(".status span");
      statusElement.textContent = newStatus;
    }
  </script>
</head>
<body>
  <header>
    <h1>Staff Dashboard</h1>
  </header>
  
  <div class="sidebar">
    <ul>
      <li><a href="#">Dashboard</a></li>
      <li><a href="#">Tasks</a></li>
      <li><a href="#">Messages</a></li>
      <li><a href="#">Calendar</a></li>
      <li><a href="#">Settings</a></li>
    </ul>
  </div>

  <div class="content">
  <?php
  include("../php/dataconnection.php");

    // Query to retrieve staff name from the staff table
    $query = "SELECT staff_name FROM staff LIMIT 909";  // Modify the query according to your table structure

    // Execute the query
    $result = mysqli_query($connection, $query);

    if ($result) {
      // Fetch the result row
      $row = mysqli_fetch_assoc($result);
      $staffName = $row['staff_name'];

      // Display the staff name
      echo "<h2>Welcome, $staffName</h2>";
    } else {
      echo "Error: " . mysqli_error($connection);
    }

    // Close the connection
    mysqli_close($connection);
    ?>



    <!-- Delivery features -->
    <div class="delivery-section">
      <h3>Delivery</h3>

      <!-- Delivery Card 1 -->
      <div class="delivery-card" id="delivery-card-1">
      <?php
        include("../php/dataconnection.php");

        // Retrieve payment data from the payment table
        $selectQuery = "SELECT payment_id, payment_type, fee, customer_address FROM payment";
        $result = mysqli_query($connection, $selectQuery);
        ?>

        <!-- HTML template -->
        <!-- Iterate through the fetched payment data and display it -->
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
          <div class="delivery-card" id="delivery-card-<?php echo $row['payment_id']; ?>">
            <div class="title"><?php echo $row['payment_type']; ?></div>
            <div class="description">Fee: <?php echo $row['fee']; ?></div>
            <div class="status">
              Customer Address: <?php echo $row['customer_address']; ?>
            </div>
            <!-- Rest of the HTML template -->
          </div>
        <?php } ?>

        <div class="status">
          Status: <span class="delivered">Delivered</span>
        </div>
        <div class="change-status">
          Change status:
          <button onclick="changeDeliveryStatus('delivery-card-1', 'Pending')">Pending</button>
          <button onclick="changeDeliveryStatus('delivery-card-1', 'In Kitchen')">In Kitchen</button>
          <button onclick="changeDeliveryStatus('delivery-card-1', 'Delivered')">Delivered</button>
        </div>
        <div class="google-map">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3984.2236217501277!2d101.66115507483438!3d3.034591096941259!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cdb36044fe6151%3A0x8c7d727d8b83d535!2sIntellogic%20Technology%20Sdn%20Bhd!5e0!3m2!1sen!2smy!4v1688394741294!5m2!1sen!2smy" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
      </div>

      <!-- Delivery Card 2 -->
      <div class="delivery-card" id="delivery-card-2">
        <div class="title">Package 2</div>
        <div class="description">Pizza Hawaiian.</div>
        <div class="status">
          Status: <span class="pending">Pending</span>
        </div>
        <div class="change-status">
          Change status:
          <button onclick="changeDeliveryStatus('delivery-card-2', 'Pending')">Pending</button>
          <button onclick="changeDeliveryStatus('delivery-card-2', 'In Kitchen')">In Kitchen</button>
          <button onclick="changeDeliveryStatus('delivery-card-2', 'Delivered')">Delivered</button>
        </div>
        <div class="google-map">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3984.2236217501277!2d101.66115507483438!3d3.034591096941259!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cdb36044fe6151%3A0x8c7d727d8b83d535!2sIntellogic%20Technology%20Sdn%20Bhd!5e0!3m2!1sen!2smy!4v1688394741294!5m2!1sen!2smy" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
      </div>
    </div>

    <!-- Check-in/out features -->
    <form id="attendance-form">
  <div class="check-in-out-section">
    <h3>Check-in/out</h3>

    <div class="check-in-out-card" id="check-in-card">
      <div class="title">Check-in</div>
      <div class="timestamp">Timestamp: [Check-in Time]</div>
      <div class="check-button">
        <button type="button" onclick="checkIn()">Check-in</button>
      </div>
    </div>

    <div class="check-in-out-card" id="check-out-card">
      <div class="title">Check-out</div>
      <div class="timestamp">Timestamp: [Check-out Time]</div>
      <div class="check-button">
        <button type="button" onclick="checkOut()">Check-out</button>
      </div>
    </div>
  </div>
</form>

    <!-- Place your additional content here -->
  </div>

  <footer>
    &copy; 2023 Staff Dashboard
  </footer>
</body>
</html>
