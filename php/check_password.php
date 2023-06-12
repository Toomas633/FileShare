<?php
require_once '../config.php';
session_set_cookie_params(0);
session_start();
$pdo = new PDO('sqlite:' . DB_FILE);
$query = $pdo->prepare('SELECT value FROM settings WHERE setting = :setting');
$query->bindValue(':setting', 'password', PDO::PARAM_STR);
$query->execute();
$row = $query->fetch(PDO::FETCH_ASSOC);
$correct_password = $row['value'];
$pdo = null;
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
