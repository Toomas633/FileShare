<?php
require_once('../config.php');
$file = $_GET['file'];
$dir = DIR_PATH . "uploads/";
if (file_exists($dir . $file)) {
  if (unlink($dir . $file)) {
    $status = "File deleted successfully.";
  } else {
    $status = "Error deleting file.";
  }
} else {
  $status = "File not found.";
}
header("Location: ../settings.php?status=" . urlencode($status));
exit();
