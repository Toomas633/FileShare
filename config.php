<?php
ini_set('display_errors', 1);
$current_file_path = __FILE__;
$current_file_dir = dirname($current_file_path);
define('DIR_PATH', $current_file_dir . '/');
define('DB_FILE', $current_file_dir . '/db/database.db');
error_reporting(E_ALL & ~E_WARNING & ~E_DEPRECATED);
chdir($current_file_dir);