<?php
require_once 'path.php';
date_default_timezone_set('UTC');
define('DB_FILE', DEFAULT_PATH . '/db/database.db');
ini_set('error_log', 'cleanup.log');


function delete_entries()
{
    $conn = new PDO('sqlite:' . DB_FILE);
    $files_in_folder = array();
    $files_in_database = array();
    if (is_dir("uploads/")) {
        $directory = new DirectoryIterator("uploads/");
        foreach ($directory as $file) {
            if ($file->isFile()) {
                $files_in_folder[] = $file->getFilename();
            }
        }
    }
    try {
        $pdo = new PDO("sqlite:" . DB_FILE);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "SELECT name FROM files";
        $stmt = $pdo->query($query);
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $files_in_database[] = $row['name'];
        }
    } catch (PDOException $e) {
        echo $e;
    }
    foreach ($files_in_database as $filename) {
        if (!in_array($filename, $files_in_folder)) {
            $stmt = $conn->prepare("DELETE FROM files WHERE name = :filename");
            $stmt->bindParam(':filename', $filename);
            $stmt->execute();
            error_log("Deleted entry for file:" . $filename . PHP_EOL, 3, 'cleanup.log');
        }
    }
    $conn = null;
}

function delete_files()
{
    try {
        $conn = new PDO('sqlite:' . DB_FILE);;
        $stmt = $conn->query("SELECT * FROM files");
        $current_time = time() * 1000;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $name = $row['name'];
            $upload_time = $row['uploadTime'];
            $delete_time = $row['deleteTime'];
            if ($current_time > $delete_time && $delete_time != $upload_time) {
                $file_path = 'uploads/' . $name;
                if (file_exists($file_path)) {
                    error_log("Deleted file: " . $name . "\t Delete time in db(utc): " . $delete_time . PHP_EOL, 3, 'cleanup.log');
                    unlink($file_path);
                }
            }
        }
    } catch (PDOException $e) {
        echo $e;
    }
    $conn = null;
}

try {
    delete_files();
} catch (Exception $e) {
    error_log($e, 3, 'cleanup.log');
}

try {
    delete_entries();
} catch (Exception $e) {
    error_log($e, 3, 'cleanup.log');
}
