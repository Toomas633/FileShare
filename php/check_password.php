<?php
$password_file = "admin_password.txt"; // Path to password file
$correct_password = trim(file_get_contents($password_file)); // Read password from file and remove whitespace

if (isset($_POST["password"])) {
	$password = $_POST["password"];

	if ($password == $correct_password) {
		header("Location: ../settings.html");
		exit();
	} else {
		header("Location: ../login.php?error=1");
		exit();
	}
}
?>