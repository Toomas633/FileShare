<?php
require_once('../config.php');
$pdo = new PDO('sqlite:' . DB_FILE);
$query = $pdo->prepare('SELECT value FROM settings WHERE setting = :setting');
$query->bindValue(':setting', 'timezone', PDO::PARAM_STR);
$query->execute();
$row = $query->fetch(PDO::FETCH_ASSOC);
$timezone = $row['value'];
$pdo = null;
echo $timezone;
