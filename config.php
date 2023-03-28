<?php
chdir($current_file_dir);
error_reporting(E_ALL & ~E_WARNING & ~E_DEPRECATED);
ini_set('display_errors', 1);

$folderName = "uploads/";
if (!file_exists($folderName)) {
    mkdir($folderName, 0777, true);
}

$db = 'db/database.db';
if (!file_exists($db)) {
    $password = password_hash(getenv('PASSWORD'), PASSWORD_BCRYPT);
    $tz = getenv('TZ');
    $db = new SQLite3($db);
    $db->exec('CREATE TABLE files (name TEXT NOT NULL, uploadTime INT NOT NULL, deleteTime INT NOT NULL)');
    $db->exec('CREATE TABLE settings (setting TEXT NOT NULL, value TEXT NOT NULL)');
    $db->exec('CREATE TABLE settings (setting TEXT NOT NULL, value TEXT NOT NULL)');
    $db->exec("INSERT INTO settings (setting, value) VALUES ('password', '$password')");
    $db->exec("INSERT INTO settings (setting, value) VALUES ('timezone', '$tz')");
    $db->exec("INSERT INTO settings (setting, value) VALUES ('url', 'http://localhost:8000/')");
}

$current_file_path = __FILE__;
$current_file_dir = dirname($current_file_path);
define('DIR_PATH', $current_file_dir . '/');
define('DB_FILE', $current_file_dir . '/db/database.db');