<?php
$targetDir = "../uploads/";
$extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
$random = intval($_POST['random']);
$direct =intval($_POST['direct']);
if ($random == 0){
    $fileName = pathinfo($_FILES['file']['name'],PATHINFO_BASENAME);
} else {
    $fileName = uniqid() . '.' . $extension;
}
$targetFile = $targetDir . $fileName;
$uploadOk = 1;
$errorMsg = "";
$linkBeginning = file_get_contents("../db/link_address.txt");
if (file_exists($targetFile)) {
    $errorMsg = "ERROR: Sorry, file already exists.";
    $uploadOk = 0;
}
if (intval($_FILES["file"]["size"]) > 5000000) {
    $errorMsg = "ERROR: Sorry, your file is too large.";
    $uploadOk = 0;
}
if ($uploadOk == 0) {
    echo $errorMsg;
} else {
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
        if ($direct == 1) {
            $fileUrl = $linkBeginning ."uploads/". $fileName;
            echo $fileUrl;
        } else {
            $fileUrl = $linkBeginning . "download.php?file=" . $fileName;
            echo $fileUrl;
        }
    } else {
        echo "ERROR: Sorry, there was an error uploading your file." . $fileName;
    }
}