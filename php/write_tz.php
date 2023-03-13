<?php
// Get the timezone from the AJAX request
$timezone = $_POST['timezone'];

// Write the timezone to a file
$file = fopen('tz.txt', 'w');
if ($file) {
  fwrite($file, $timezone);
  fclose($file);
  http_response_code(200);
} else {
  http_response_code(500);
}
?>