<?php
require_once 'path.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type");
define('DIR_PATH', DEFAULT_PATH . '/');
define('DB_FILE', DIR_PATH . 'db/database.db');
ini_set('error_log', DIR_PATH . 'FileShare.log');
error_reporting(E_ALL & ~E_WARNING & ~E_DEPRECATED & ~E_NOTICE);
include_once 'cleanup.php';
