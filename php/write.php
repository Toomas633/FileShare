<?php
require_once('../config.php');
$data = json_decode($_POST['data'], true);
$name = $data->name;
$upload = $data->uploadTime;
$delete = $data->deleteTime;
try {
    $pdo = new PDO('sqlite:' . DB_FILE2);
    $query = $pdo->prepare("INSERT INTO files (name, uploadTime, deleteTime) VALUES (:name, :uploadtime, :deletetime)");
    $query->bindValue(':name', $name, PDO::PARAM_STR);
    $query->bindValue(':uploadtime', intval($upload), PDO::PARAM_INT);
    $query->bindValue(':deletetime', intval($delete), PDO::PARAM_INT);
    $query->execute();
    $pdo = null;
    echo ("Data successfully added to database.");
} catch (Exception $e) {
    echo "Error adding data to database.";
};
