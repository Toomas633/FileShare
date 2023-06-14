<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type");
require_once 'path.php';
define('DB_FILE', DEFAULT_PATH . '/db/database.db');
define('DIR_PATH', DEFAULT_PATH . '/');
error_reporting(E_ALL & ~E_WARNING & ~E_DEPRECATED & ~E_NOTICE);
ini_set('error_log', DEFAULT_PATH . '/FileShare.log');
