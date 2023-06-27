<?php
require_once 'path.php';
date_default_timezone_set('UTC');
ini_set('error_log', DIR_PATH . '/cleanup.log');

function delete_entries()
{
    $conn = new PDO('sqlite:' . DB_FILE);;
    $files_in_folder = scandir(DIR_PATH . "uploads/");
    $files_in_database = [];
    $result = $conn->query("SELECT name FROM files");
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $files_in_database[] = $row['name'];
    }
    foreach ($files_in_database as $filename) {
        if (!in_array($filename, $files_in_folder)) {
            $conn->exec("DELETE FROM files WHERE name = '$filename'");
            error_log("Deleted entry for file: $filename", 3, DIR_PATH . '/cleanup.log');
        }
    }
    $conn = null;
}

function delete_files()
{
    $conn = new PDO('sqlite:' . DB_FILE);;
    $result = $conn->query("SELECT * FROM files");
    $current_time = time() * 1000;
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $name = $row['name'];
        $upload_time = $row['upload_time'];
        $delete_time = $row['delete_time'];
        if ($current_time > $delete_time && $delete_time != $upload_time) {
            $file_path = DIR_PATH . 'uploads/' . $name;
            if (file_exists($file_path)) {
                error_log("Deleted file: $name \t Delete time in db(utc): $delete_time", 3, DIR_PATH . '/cleanup.log');
                unlink($file_path);
            }
        }
    }
    $conn = null;
}

try {
    delete_files();
} catch (Exception $e) {
    error_log($e, 3, DIR_PATH . 'cleanup.log');
}

try {
    delete_entries();
} catch (Exception $e) {
    error_log($e, 3, DIR_PATH . 'cleanup.log');
}