<?php
	include('dataconnection.php');
 
	$promo_id=$_POST['promo_id'];
	$discount=$_POST['discount'];
    $promo_duration=$_POST['promo_duration'];
    $promo_condition=$_POST['promo_condition'];
 
	mysqli_query($connection,"insert into `promotion` (promo_id,discount,promo_duration,promo_condition) values ('$promo_id','$discount','$promo_duration','$promo_condition')");
	header('location:createpromotion.php');
 
?>