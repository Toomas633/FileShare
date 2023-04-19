<?php
require_once('config.php');
session_set_cookie_params(0);
session_start();
if (isset($_SESSION['logged_in']) || $_SESSION['logged_in'] === true) {
	header('Location: settings.php');
	exit;
}
?>
<!DOCTYPE html>
<html lang="eng">

<head>
	<meta charset="UTF-8">
	<title>Login</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="css/login.css">
	<link rel="icon" type="image/png" href="icons/fav.png">
</head>

<body>
	<div id="top-bar">
		<h1 id="page-name"><a href="index.php" style="text-decoration: none;" id="page-name"><i class='fas fa-icon'></i>FileShare</a></h1>
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
