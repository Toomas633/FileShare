<?php
define('DB_FILE', 'db/database.db');
define('DB_FILE2', '../db/database.db');
ini_set('display_errors', 1);
$php_path = PHP_BINDIR . '/..';
$ext_path = $php_path . '/lib/php/extensions/no-debug-non-zts-' . PHP_MAJOR_VERSION . '.' . PHP_MINOR_VERSION . '/' . 'sqlite3.so';
ini_set('sqlite3.extension_dir', $ext_path);
error_reporting(E_ALL & ~E_WARNING & ~E_DEPRECATED);