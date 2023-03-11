<!DOCTYPE html>
<html>

<head>
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="css/login.css">
	<link rel="icon" type="image/png" href="icons/fav.png">
</head>

<body>
	<div id="top-bar">
		<h1 id="page-name">File Upload</h1>
		<a href="/" id="back-button">&#8678; Back</a>
	</div>
	<div class="container">
		<div class="card">
			<h1>Login</h1>
			<form action="php/check_password.php" method="POST">
				<label for="password">Password:</label>
				<input type="password" id="password" name="password" required>
				<?php
				if (isset($_GET["error"])) {
					echo "<p class='error'>Invalid password.</p>";
				}
				?>
				<button type="submit">Login</button>
			</form>
		</div>
	</div>
	<script type="text/javascript" src="js/logout.js"></script>
</body>

</html>