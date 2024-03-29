<?php
sleep(10);
require_once 'config.php';

if (!file_exists('uploads/')) {
    mkdir('uploads/', 0777, true);
}
if (!file_exists('db/')) {
    mkdir('db/', 0777, true);
}
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
if (!file_exists(DB_FILE)) {
    $errors = true;
    createSettings($errors);
    createFiles($errors);
    write('password', $password);
    write('timezone', $tz);
    write('url', 'http://localhost:8000');
} else {
    $errors = false;
    createFiles($errors);
    createSettings($errors);
    if (!check('password')) {
        write('password', $password);
    }
    if (!check('timezone')) {
        write('timezone', $tz);
    }
    if (!check('url')) {
        write('url', 'http://localhost:8000');
    }
}

function createSettings($errors) {
    try {
        $db = new PDO('sqlite:' . DB_FILE);
        $query = $db->prepare("CREATE TABLE settings (setting TEXT, value TEXT)");
        $query->execute();
        $db = $query = null;
    } catch (PDOException $e) {
        if ($errors === true) {
            echo 'Error: Unable to create table "settings"';
        }
        echo $e;
    }
}

function createFiles($errors) {
    try {
        $db = new PDO('sqlite:' . DB_FILE);
        $query = $db->prepare("CREATE TABLE files (name TEXT, uploadTime INT, deleteTime INT)");
        $query->execute();
        $db = $query = null;
    } catch (PDOException $e) {
        if ($errors === true) {
            echo 'Error: Unable to create table "files"';
        }
        echo $e;
    }
}

function write($setting, $value) {
    try {
        $db = new PDO('sqlite:' . DB_FILE);
        $query = $db->prepare("INSERT INTO settings (setting, value) VALUES (:setting, :value)");
        $query->bindValue(':setting', $setting, PDO::PARAM_STR);
        $query->bindValue(':value', $value, PDO::PARAM_STR);
        $query->execute();
        $db = $query = null;
    } catch (PDOException $e) {
        echo 'Error: Unable to insert ' . $setting . ' to table "settings"';
        echo $e;
    }
}

function check($value) {
    $db = new PDO('sqlite:' . DB_FILE);
    $query = $db->prepare('SELECT COUNT(*) FROM settings WHERE setting = :value');
    $query->bindValue(':value', $value, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_NUM);
    $db = $query = null;
    if ($result[0] > 0) {
        return true;
    } else {
        return false;
    }
}
