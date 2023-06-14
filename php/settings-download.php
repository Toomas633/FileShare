<?php
require_once '../config.php';
if (isset($_POST['filename'])) {
    $filename = $_POST['filename'];
    if (file_exists($filename)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filename));
        readfile($filename);
        exit;
    } else {
        echo "ERROR: File not found.";
        header("HTTP/1.1 200 OK");
        header("Content-Type: text/plain");
    }
} else {
    echo "ERROR: Filename not provided.";
    header("HTTP/1.1 200 OK");
    header("Content-Type: text/plain");
}
