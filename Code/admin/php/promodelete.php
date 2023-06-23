<?php
	$id=$_GET['id'];
	include('dataconnection.php');
	mysqli_query($connection,"delete from `promotion` where userid='$id'");
	header('location:createpromotion.php');
?>