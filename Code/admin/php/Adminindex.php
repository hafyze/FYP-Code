<DOCTYPE html>
<html>
<head>
<title>Administrator</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

<div class="sidenav">
  <a href="insertstaff.php">Staff Management</a>
 <a href="productindex.php">Product List</a>
 <a href="promotionindex.php">Promotion</a>
 <a href="paymentindex.php">View Payment</a>
 <a href="logout.php">Logout</a>
</div>

<div class="main">
  <h2>Administration Interface</h2>
  <p>Welcome back</p>
</div>

<script>
/* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
var dropdown = document.getElementsByClassName("dropdown-btn");
var i;

for (i = 0; i < dropdown.length; i++) {
  dropdown[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var dropdownContent = this.nextElementSibling;
    if (dropdownContent.style.display === "block") {
      dropdownContent.style.display = "none";
    } else {
      dropdownContent.style.display = "block";
    }
  });
}
</script>

</body>
</html> 