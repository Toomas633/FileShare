<?php
require_once('path.php');
define('DB_FILE', DEFAULT_PATH . '/db/database.db');
define('DIR_PATH', DEFAULT_PATH . '/');
//error_reporting(E_ALL & ~E_WARNING & ~E_DEPRECATED & ~E_NOTICE);
ini_set('display_errors', 1);

if (!file_exists('uploads/')) {
    mkdir('uploads/', 0777, true);
}

if (!file_exists('db/')) {
    mkdir('db/', 0777, true);
}