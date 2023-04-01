<?php
require_once('path.php');
define('DIR_PATH', DIR_PATH. '/');
define('DB_FILE', DIR_PATH . '/db/database.db');
error_reporting(E_ALL & ~E_WARNING & ~E_DEPRECATED & ~E_NOTICE);
ini_set('display_errors', 0);
function changePathOnFirstRun() {
    static $firstRun = true;
    if ($firstRun) {
        chdir(DIR_PATH);
        if (!file_exists("uploads/")) {
            mkdir("uploads/", 0777, true);
        }
        if (!file_exists("db/")) {
            mkdir("db/", 0777, true);
        }
        createDB(DIR_PATH);
        $firstRun = false;
    }
}

function createDB($current_file_dir) {
    define('DEFAULT_PASS', '$2y$10$Wd3nh6Kg6bRv6TpKz0E5eOrvONkObd7JhQmkeFV2QbVOHZqDSfkkK');
    define('DEFAULT_TZ', 'Europe/London');
    if (!file_exists($current_file_dir . '/db/database.db')) {
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
        try {
            $db = new PDO('sqlite:' . $current_file_dir . '/db/database.db');
            $query=$db->prepare("CREATE TABLE files (name TEXT, uploadTime INT, deleteTime INT)");
            $query->execute();
            $db = $query = null;
        } catch (PDOException $e){
            echo 'Error: Unable to create table files';
        }
        try {
            $db = new PDO('sqlite:' . $current_file_dir . '/db/database.db');
            $query=$db->prepare("CREATE TABLE settings (setting TEXT, value TEXT)");
            $query->execute();
            $db = $query = null;
        } catch (PDOException $e){
            echo 'Error: Unable to create table settings';
        }
        try {
            $db = new PDO('sqlite:' . $current_file_dir . '/db/database.db');
            $query=$db->prepare("INSERT INTO settings (setting, value) VALUES ('password', :password)");
            $query->bindValue(':password', $password, PDO::PARAM_STR);
            $query->execute();
            $db = $query = null;
        } catch (PDOException $e){
            echo 'Error: Unable to insert password to table settings';
        }
        try {
            $db = new PDO('sqlite:' . $current_file_dir . '/db/database.db');
            $query=$db->prepare("INSERT INTO settings (setting, value) VALUES ('timezone', :tz)");
            $query->bindValue(':tz', $tz, PDO::PARAM_STR);
            $query->execute();
            $db = $query = null;
        } catch (PDOException $e){
            echo 'Error: Unable to insert timezone to table settings';
        }
        try {
            $db = new PDO('sqlite:' . $current_file_dir . '/db/database.db');
            $query=$db->prepare("INSERT INTO settings (setting, value) VALUES ('url', :url)");
            $query->bindValue(':url', 'http://localhost:8000/', PDO::PARAM_STR);
            $query->execute();
            $db = $query = null;
        } catch (PDOException $e){
            echo 'Error: Unable to insert url to table settings';
        }
    }
}