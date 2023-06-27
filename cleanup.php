<?php
ini_set('error_log', DEFAULT_PATH . '/cleanup.log');
date_default_timezone_set('UTC');

function delete_entries()
{
    $conn = new SQLite3('db/database.db');
    $files_in_folder = scandir("uploads/");
    $files_in_database = [];
    $result = $conn->query("SELECT name FROM files");
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $files_in_database[] = $row['name'];
    }
    foreach ($files_in_database as $filename) {
        if (!in_array($filename, $files_in_folder)) {
            $conn->exec("DELETE FROM files WHERE name = '$filename'");
            error_log("Deleted entry for file: $filename", 3, 'cleanup.log');
        }
    }
    $conn->close();
}

function delete_files()
{
    $conn = new SQLite3('db/database.db');
    $result = $conn->query("SELECT * FROM files");
    $current_time = time() * 1000;
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $name = $row['name'];
        $upload_time = $row['upload_time'];
        $delete_time = $row['delete_time'];
        if ($current_time > $delete_time && $delete_time != $upload_time) {
            $file_path = 'uploads/' . $name;
            if (file_exists($file_path)) {
                error_log("Deleted file: $name \t Delete time in db(utc): $delete_time", 3, 'cleanup.log');
                unlink($file_path);
            }
        }
    }
    $conn->close();
}

echo "Started cleanup.php\n";

while (true) {
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
    sleep(60);
}
