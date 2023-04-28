<?php
require_once('path.php');
define('DB_FILE', DEFAULT_PATH . '/db/database.db');
define('DIR_PATH', DEFAULT_PATH . '/');
error_reporting(E_ALL & ~E_WARNING & ~E_DEPRECATED & ~E_NOTICE);
ini_set('log_errors', 1);
ini_set('error_log', DEFAULT_PATH . '/FileShare.log');
ini_set('include_path', DEFAULT_PATH . 'FileShare.ini');
