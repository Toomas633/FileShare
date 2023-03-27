<?php
require_once('../config.php');
if (isset($_POST['filename'])) {
    $file = $_POST['filename'];
    $filepath = DIR_PATH . 'uploads/' . $file;
    $filename = basename($file);
    if (!file_exists($filepath)) {
        $status = "File not found.";
        header("Location: " . DIR_PATH . "settings.php?status=" . urlencode($status));
        exit();
    }
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Content-Length: ' . filesize($filepath));
    readfile($filepath);
    header("Location: ../settings.php?status=" . urlencode($status));
    exit();
}
