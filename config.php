<?php
$pdo = new PDO('sqlite: db/database.db');
$query = $pdo->prepare('SELECT value FROM settings WHERE setting = :setting');
$query->bindValue(':setting', 'path', PDO::PARAM_STR);
$query->execute();
$row = $query->fetch(PDO::FETCH_ASSOC);
$path = $row['value'];
define('DB_FILE', $path . '/db/database.db');
define('DIR_PATH', $path . '/');
error_reporting(E_ALL & ~E_WARNING & ~E_DEPRECATED & ~E_NOTICE);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', $path . '/FileShare.log');