<?php
require_once('../config.php');
$data = json_decode($_POST['data'], true);
$json = file_get_contents('../db/database.json');
$arr_data = json_decode($json, true);
array_push($arr_data['files'], $data);
$json_data = json_encode($arr_data, JSON_PRETTY_PRINT);
if (file_put_contents('../db/database.json', $json_data)) {
    echo("Data successfully added to JSON file.");
} else {
    echo "Error adding data to JSON file.";
}
