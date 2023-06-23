<!DOCTYPE html>
<html>
<head>
<title>Staff Registration</title>
</head>
<body>
<?php
$page_title = 'Directory : Registration';

echo '<div class="header">
	<h1>Admin - Staff Registration</h1>
</div>';
?>
	<div>
		<form method="POST" action="addstaff.php">
			<label>Name:</label><br>
      <input type="text" name="staff_name" value="<?php if (isset($_POST['staff_name'])) echo $_POST['staff_name']; ?>" /></p>
			<label>Contact:</label><br>
      <input type="tel" name="staff_contact" value="<?php if (isset($_POST['staff_contact'])) echo $_POST['staff_contact']; ?>" /></p>
      <label>Email Address:</label><br>
      <input type="text" name="staff_email" value="<?php if (isset($_POST['staff_email'])) echo $_POST['staff_email']; ?>" /></p>
      <label for="staff_role">Role:</label>
      <label>Staff Role:</label><br>
      <select name="staff_role" type="text">
      <option>Volvo</option>
      <option>Saab</option>
      <option>Opel</option>
      <option>Audi</option>
      </select>
      <br><label>Password: </label><br>
		  <input type="password" name="staff_pass"><br>
			<br><input type="submit" name="add">
		</form>
	</div>
	<br>
	<div>
		<table border="1" cellspacing="0" cellpadding="0">
			<thead>
				<th>Name</th>
				<th>Contact</th>
				<th>Email Address</th>
        <th>Role</th>
        <th>Password</th>
			</thead>
			<tbody>
				<?php
					include('dataconnection.php');
					$query=mysqli_query($connection,"select * from `staff`");
					while($row=mysqli_fetch_array($query)){
						?>
						<tr>
							<td><?php echo $row['staff_name']; ?></td>
							<td><?php echo $row['staff_contact']; ?></td>
							<td><?php echo $row['staff_email']; ?></td>
              <td><?php echo $row['staff_role']; ?></td>
              <td><?php echo $row['staff_pass']; ?></td>
								<a href="edit.php?id=<?php echo $row['userid']; ?>">Edit</a>
								<a href="delete.php?id=<?php echo $row['userid']; ?>">Delete</a>
							</td>
						</tr>
						<?php
					}
				?>
			</tbody>
		</table>
	</div>
</body>
</html>