<?php
require_once('../config.php');
$timezone = file_get_contents('../db/tz.txt');
echo $timezone;
