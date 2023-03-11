<?php
// Get data from POST request
$data = json_decode($_POST['data'], true);

// Read existing JSON file
$json = file_get_contents('../db/database.json');

// Decode JSON data into array
$arr_data = json_decode($json, true);

// Append new data to array
array_push($arr_data['files'], $data);

// Encode updated array as JSON
$json_data = json_encode($arr_data, JSON_PRETTY_PRINT);

// Write JSON data to file
if (file_put_contents('../db/database.json', $json_data)) {
    echo("Data successfully added to JSON file.");
} else {
    echo "Error adding data to JSON file.";
}
?>