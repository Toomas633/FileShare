<?php
require_once('../config.php');
$file = $_GET['file'];
$dir = DIR_PATH . "uploads/";
if (file_exists($dir . $file)) {
    if (unlink($dir . $file)) {
        header("Location: ../index.php");
        exit();
    } else {
        $status = "Error deleting file.";
    }
} else {
    $status = "File not found.";
}
header("Location: ../download.php?file=" . urlencode($file) . "?status=" . urlencode($status));
exit();
