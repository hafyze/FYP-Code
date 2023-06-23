<?php
	include('dataconnection.php');
 
	$staff_name=$_POST['staff_name'];
	$staff_contact=$_POST['staff_contact'];
    $staff_email=$_POST['staff_email'];
    $staff_role=$_POST['staff_role'];
    $staff_pass=$_POST['staff_pass'];
 
	mysqli_query($connection,"insert into `staff` (staff_name,staff_contact,staff_email,staff_role,staff_pass) values ('$staff_name','$staff_contact','$staff_email','$staff_role','$staff_pass')");
	header('location:insertstaff.php');
 
?>