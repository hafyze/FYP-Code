<!DOCTYPE html>
<html>
<head>
<title>Create Promotion</title>
</head>
<body>
<?php
$page_title = 'Directory : Registration';

echo '<div class="header">
	<h1>Admin - Create Promotion</h1>
</div>';
?>
	<div>
		<form method="POST" action="addpromotion.php">
			<label>ID:</label>
            <input type="text" id="promo_id"><br>
            <label>Discount:</label>
            <input type="text" id="discount">
            <label>Duration:</label>
            <input type="date" id="promo_duration"><input type="date" id="promo_duration"><br>
            <label>Condition:</label>
            <input type="text" id="promo_condition">
			<br><input type="submit" name="add">
		</form>
	</div>
	<br>
	<div>
		<table border="1">
			<thead>
				<th>ID</th>
				<th>Discount</th>
				<th>Duration</th>
                <th>Condition</th>
			</thead>
			<tbody>
				<?php
					include('dataconnection.php');
					$query=mysqli_query($connection,"select * from `promotion`");
					while($row=mysqli_fetch_array($query)){
						?>
						<tr>
							<td><?php echo $row['promo_id']; ?></td>
							<td><?php echo $row['discount']; ?></td>
							<td><?php echo $row['promo_duration']; ?></td>
                            <td><?php echo $row['promo_condition']; ?></td>
								<a href="promodelete.php?id=<?php echo $row['userid']; ?>">Delete</a>
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