<?php
sleep(10);
if (!file_exists('uploads/')) {
    mkdir('uploads/', 0777, true);
}
if (!file_exists('db/')) {
    mkdir('db/', 0777, true);
}
error_reporting(E_ALL & ~E_WARNING & ~E_DEPRECATED & ~E_NOTICE);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', DEFAULT_PATH . '/FileShare.log');
if (!file_exists(DB_FILE)) {
    if (getenv('PASSWORD') !== false) {
        $password = password_hash(getenv('PASSWORD'), PASSWORD_BCRYPT);
    } else {
        $password = '$2y$10$Wd3nh6Kg6bRv6TpKz0E5eOrvONkObd7JhQmkeFV2QbVOHZqDSfkkK';
    }
    if (getenv('TZ') !== false) {
        $tz = getenv('TZ');
    } else {
        $tz = 'Europe/London';
    }
    try {
        $db = new PDO('sqlite:' . DB_FILE);
        $query = $db->prepare("CREATE TABLE files (name TEXT, uploadTime INT, deleteTime INT)");
        $query->execute();
        $db = $query = null;
    } catch (PDOException $e) {
        echo 'Error: Unable to create table files';
    }
    try {
        $db = new PDO('sqlite:' . DB_FILE);
        $query = $db->prepare("CREATE TABLE settings (setting TEXT, value TEXT)");
        $query->execute();
        $db = $query = null;
    } catch (PDOException $e) {
        echo 'Error: Unable to create table settings';
    }
    try {
        $db = new PDO('sqlite:' . DB_FILE);
        $query = $db->prepare("INSERT INTO settings (setting, value) VALUES ('password', :password)");
        $query->bindValue(':password', $password, PDO::PARAM_STR);
        $query->execute();
        $db = $query = null;
    } catch (PDOException $e) {
        echo 'Error: Unable to insert password to table settings';
    }
    try {
        $db = new PDO('sqlite:' . DB_FILE);
        $query = $db->prepare("INSERT INTO settings (setting, value) VALUES ('timezone', :tz)");
        $query->bindValue(':tz', $tz, PDO::PARAM_STR);
        $query->execute();
        $db = $query = null;
    } catch (PDOException $e) {
        echo 'Error: Unable to insert timezone to table settings';
    }
    try {
        $db = new PDO('sqlite:' . $db_path);
        $query = $db->prepare("INSERT INTO settings (setting, value) VALUES ('url', :url)");
        $query->bindValue(':url', 'http://localhost:8000/', PDO::PARAM_STR);
        $query->execute();
        $db = $query = null;
    } catch (PDOException $e) {
        echo 'Error: Unable to insert url to table settings';
    }
    try {
        $db = new PDO('sqlite:' . $db_path);
        $query = $db->prepare("INSERT INTO settings (setting, value) VALUES ('max-size', :size)");
        $query->bindValue(':size', getenv('MAX_FILESIZE'), PDO::PARAM_STR);
        $query->execute();
        $db = $query = null;
    } catch (PDOException $e) {
        echo 'Error: Unable to insert url to table settings';
    }
}
