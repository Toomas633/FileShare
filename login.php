<?php
error_reporting(E_ALL & ~E_WARNING);
session_set_cookie_params(0);
session_start();
if (isset($_SESSION['logged_in']) || $_SESSION['logged_in'] === true) {
	header('Location: settings.php');
	exit;
}
?>
<!DOCTYPE html>
<html>

<head>
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="css/login.css">
	<link rel="icon" type="image/png" href="icons/fav.png">
</head>

<body>
	<div id="top-bar">
		<h1 id="page-name"><a href="index.php" style="text-decoration: none;" id="page-name">FileShare</a></h1>
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