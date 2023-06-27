<?php
require_once 'path.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type");
define('DIR_PATH', DEFAULT_PATH . '/');
define('DB_FILE', DIR_PATH . 'db/database.db');
ini_set('error_log', DIR_PATH . 'FileShare.log');
error_reporting(E_ALL & ~E_WARNING & ~E_DEPRECATED & ~E_NOTICE);

if (getenv('MAX_FILESIZE') !== false) {
    $filesize = getenv('MAX_FILESIZE');
} else {
    $filesize = '100M'; # Edit for custom size when not using docker
}

ini_set('upload_max_filesize', $filesize);
ini_set('post_max_size', $filesize);


include_once 'createDB.php';
include_once 'cleanup.php';
