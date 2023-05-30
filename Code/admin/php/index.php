<!DOCTYPE html>
<html>
<head>
	<title>LOGIN</title>
	<link rel="stylesheet" type="type/css" hreaf="style.css">
	</head>
	<body>
		<form action="login.php" method="post">
			<h2>LOGIN</h2>
			<?php if(isset($_GET['erro'])) { ?>
				<p class="error"> <?php echo $_GET['error']; ?></p>
			<?php } ?>
			<label> User Name</label>
			<input type="text" name="admin_id" placeholder="Admin Id"><br>
			<label>Password</label>
			<input type="password" name="admin_pass" placeholder="Admin Password"><br>
			
			<button type="submit">Login</button>
			</form>
	<body>
	</html>