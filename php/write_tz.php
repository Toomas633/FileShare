<?php
require_once('../config.php');
$timezone = $_POST['timezone'];
$pdo = new PDO('sqlite:' . DB_FILE2);
$query = $pdo->prepare('UPDATE settings SET value = :new_value WHERE setting = :setting');
$query->bindValue(':new_value', $timezone, PDO::PARAM_STR);
$query->bindValue(':setting', 'timezone', PDO::PARAM_STR);
$query->execute();
$pdo = null;
http_response_code(200);
