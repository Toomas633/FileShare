<?php
$file = $_GET['file'];
$dir = "../uploads/";
if (file_exists($dir . $file)) {
    if (unlink($dir . $file)) {
        header("Location: ../index.html");
        exit();
    } else {
        $status = "Error deleting file.";
    }
} else {
    $status = "File not found.";
}
header("Location: ../download.php" . "?file=" . urlencode($file) . "?status=" . urlencode($status));
exit();
