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
