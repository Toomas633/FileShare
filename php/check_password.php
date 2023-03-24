<?php
session_set_cookie_params(0);
session_start();
$password_file = "../db/admin_password.txt";
$correct_password = trim(file_get_contents($password_file));
if (isset($_POST["password"])) {
	$password = $_POST["password"];
	if (password_verify($password, $correct_password)) {
		$_SESSION["logged_in"] = true;
		header("Location: ../settings.php");
		exit();
	} else {
		header("Location: ../login.php?error=1");
		exit();
	}
}
