<?php
$timezone = $_POST['timezone'];
$file = fopen('../db/tz.txt', 'w');
if ($file) {
  fwrite($file, $timezone);
  fclose($file);
  http_response_code(200);
} else {
  http_response_code(500);
}
