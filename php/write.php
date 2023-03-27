<?php
require_once('../config.php');
$data = json_decode($_POST['data'], true);
$pdo = new PDO('sqlite:' . DB_FILE);
$query = $pdo->prepare("INSERT INTO files (name, uploadTime, deleteTime) VALUES (:name, :uploadtime, :deletetime)");
$query->bindValue(':name', $data['name'], PDO::PARAM_STR);
$query->bindValue(':uploadtime', $data['uploadTime'], PDO::PARAM_INT);
$query->bindValue(':deletetime', $data['deleteTime'], PDO::PARAM_INT);
$query->execute();
$pdo = null;
echo ("Data successfully added to database.");
