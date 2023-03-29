<?php
$current_file_path = __FILE__;
$current_file_dir = dirname($current_file_path);
chdir($current_file_dir);
define('DIR_PATH', $current_file_dir . '/');
define('DB_FILE', $current_file_dir . '/db/database.db');
error_reporting(E_ALL & ~E_WARNING & ~E_DEPRECATED & ~E_NOTICE);
ini_set('display_errors', 0);

$folderName = "uploads/";
if (!file_exists($folderName)) {
    mkdir($folderName, 0777, true);
}

if (!file_exists(DB_FILE)) {
    $password = password_hash(getenv('PASSWORD'), PASSWORD_BCRYPT);
    $tz = getenv('TZ');
    $db = new SQLite3(DB_FILE);
    $db->exec('CREATE TABLE files (name TEXT, uploadTime INT, deleteTime INT)');
    $db->exec('CREATE TABLE settings (setting TEXT, value TEXT)');
    $db->exec('CREATE TABLE settings (setting TEXT, value TEXT)');
    $db->exec("INSERT INTO settings (setting, value) VALUES ('password', '$password')");
    $db->exec("INSERT INTO settings (setting, value) VALUES ('timezone', '$tz')");
    $db->exec("INSERT INTO settings (setting, value) VALUES ('url', 'http://localhost:8000/')");
}