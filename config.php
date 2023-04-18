<?php
require_once('path.php');
define('DB_FILE', DEFAULT_PATH . '/db/database.db');
define('DIR_PATH', DEFAULT_PATH . '/');
error_reporting(E_ALL & ~E_WARNING & ~E_DEPRECATED & ~E_NOTICE);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', DEFAULT_PATH . '/FileShare.log');
ini_set('upload_max_filesize', getenv('MAX_FILESIZE'));
ini_set('post_max_size', getenv('MAX_FILESIZE'));

// $pdo = new PDO('sqlite:' . DB_FILE);
// $query = $pdo->prepare('UPDATE settings SET value = :new_value WHERE setting = :setting');
// $query->bindValue(':new_value', 'UTC', PDO::PARAM_STR);
// $query->bindValue(':setting', 'timezone', PDO::PARAM_STR);
// $query->execute();
// $pdo = null;
// http_response_code(200);