<?php
require_once '../config.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

$targetDir = DIR_PATH . "uploads/";
$extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
$random = intval($_POST['random']);
$direct = intval($_POST['direct']);

if (!empty($_FILES['file']['name'])) {
    if ($random == 0) {
        $fileName = pathinfo($_FILES['file']['name'], PATHINFO_BASENAME);
    } else {
        $fileName = uniqid() . '.' . $extension;
    }
    $targetFile = $targetDir . $fileName;
    $uploadOk = 1;
    $errorMsg = "";

    if (file_exists($targetFile)) {
        $errorMsg = "ERROR: Sorry, file already exists.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo $errorMsg;
        header("HTTP/1.1 200 OK");
        header("Content-Type: text/plain");
    } else {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
            $pdo = new PDO('sqlite:' . DB_FILE);
            $query = $pdo->prepare('SELECT value FROM settings WHERE setting = :setting');
            $query->bindValue(':setting', 'url', PDO::PARAM_STR);
            $query->execute();
            $row = $query->fetch(PDO::FETCH_ASSOC);
            $linkBeginning = $row['value'];
            $pdo = null;

            if ($direct == 1) {
                $fileUrl = $linkBeginning . "uploads/" . $fileName;
                echo $fileUrl;
            } else {
                $fileUrl = $linkBeginning . "download.php?file=" . $fileName;
                echo $fileUrl;
            }
            header("HTTP/1.1 200 OK");
            header("Content-Type: text/plain");
        } else {
            echo "ERROR: Sorry, your file is too large.";
            header("HTTP/1.1 200 OK");
            header("Content-Type: text/plain");
        }
    }
} else {
    echo "ERROR: No file selected.";
    header("HTTP/1.1 200 OK");
    header("Content-Type: text/plain");
}
