<?php
require_once('config.php');
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
            $query=$db->prepare("CREATE TABLE files (name TEXT, uploadTime INT, deleteTime INT)");
            $query->execute();
            $db = $query = null;
        } catch (PDOException $e){
            echo 'Error: Unable to create table files';
        }
        try {
            $db = new PDO('sqlite:' . DB_FILE);
            $query=$db->prepare("CREATE TABLE settings (setting TEXT, value TEXT)");
            $query->execute();
            $db = $query = null;
        } catch (PDOException $e){
            echo 'Error: Unable to create table settings';
        }
        try {
            $db = new PDO('sqlite:' . DB_FILE);
            $query=$db->prepare("INSERT INTO settings (setting, value) VALUES ('password', :password)");
            $query->bindValue(':password', $password, PDO::PARAM_STR);
            $query->execute();
            $db = $query = null;
        } catch (PDOException $e){
            echo 'Error: Unable to insert password to table settings';
        }
        try {
            $db = new PDO('sqlite:' . DB_FILE);
            $query=$db->prepare("INSERT INTO settings (setting, value) VALUES ('timezone', :tz)");
            $query->bindValue(':tz', $tz, PDO::PARAM_STR);
            $query->execute();
            $db = $query = null;
        } catch (PDOException $e){
            echo 'Error: Unable to insert timezone to table settings';
        }
        try {
            $db = new PDO('sqlite:' . DB_FILE);
            $query=$db->prepare("INSERT INTO settings (setting, value) VALUES ('url', :url)");
            $query->bindValue(':url', 'http://localhost:8000/', PDO::PARAM_STR);
            $query->execute();
            $db = $query = null;
        } catch (PDOException $e){
            echo 'Error: Unable to insert url to table settings';
        }
    }