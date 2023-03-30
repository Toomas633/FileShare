<?php
$current_file_path = __FILE__;
$current_file_dir = dirname($current_file_path);
chdir($current_file_dir);
define('DEFAULT_PASS', '$2y$10$Wd3nh6Kg6bRv6TpKz0E5eOrvONkObd7JhQmkeFV2QbVOHZqDSfkkK');
define('DEFAULT_TZ', 'Europe/London');
define('DIR_PATH', $current_file_dir . '/');
define('DB_FILE', $current_file_dir . '/db/database.db');
error_reporting(E_ALL & ~E_WARNING & ~E_DEPRECATED & ~E_NOTICE);
ini_set('display_errors', 0);

if (!file_exists("uploads/")) {
    mkdir("uploads/", 0777, true);
}
if (!file_exists("db/")) {
    mkdir("db/", 0777, true);
}

if (!file_exists(DB_FILE)) {
    if (getenv('PASSWORD') !== false) {
        $password = password_hash(getenv('PASSWORD'), PASSWORD_BCRYPT);
    } else {
        $password = DEFAULT_PASS;
    }
    if (getenv('TZ') !== false) {
        $tz = getenv('TZ');
    } else {
        $tz = DEFAULT_TZ;
    }
    $pdo = new PDO('sqlite:' . DB_FILE);
    $pdo->exec("CREATE TABLE files (name TEXT, uploadTime INT, deleteTime INT)");
    $pdo->exec("CREATE TABLE settings (setting TEXT, value TEXT)");
    $pdo->exec("INSERT INTO settings (setting, value) VALUES ('password', '$password')");
    $pdo->exec("INSERT INTO settings (setting, value) VALUES ('timezone', '$tz')");
    $pdo->exec("INSERT INTO settings (setting, value) VALUES ('url', 'http://localhost:8000/')");
    $pdo = null;
}