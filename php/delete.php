<?php
// Get the file name from the query parameter
$file = $_GET['file'];

// Define the directory path
$dir = "../";
// Check if the file exists
if (file_exists($dir . $file)) {
 
  // Delete the file
  if (unlink($dir . $file)) {
    $status = "File deleted successfully.";
  } else {
    $status = "Error deleting file.";
  }
} else {
  $status = "File not found.";
}
// Redirect back to the file list page with the status message as a query parameter
header("Location: ../settings.php?status=" . urlencode($status));
exit();
?>