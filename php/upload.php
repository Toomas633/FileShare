<?php
$targetDir = "../uploads/";
$random = intval($_GET['random']);
$extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
if ($random == 0){
    $fileName = pathinfo($_FILES['file']['name'],PATHINFO_BASENAME);
} else {
    $fileName = uniqid() . '.' . $extension;
}
$targetFile = $targetDir . $fileName;
$uploadOk = 1;
$errorMsg = "";
$imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
$linkBeginning = file_get_contents("../db/link_address.txt");
$maxFileSize = intval(file_get_contents("../db/max_size.txt"));
if (file_exists($targetFile)) {
    $errorMsg = "ERROR: Sorry, file already exists.";
    $uploadOk = 0;
}
if (isset($maxFileSize)) {
    if ($_FILES["file"]["size"] > $maxFileSize) {
        $errorMsg = "ERROR: Sorry, your file is too large.";
        $uploadOk = 0;
    }
} else {
    $errorMsg = "ERROR: Max file size not set or file unavailable.";
    $uploadOk = 0;
}
if ($uploadOk == 0) {
    echo $errorMsg;
} else {
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
        if (in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'mp4', 'webm', 'ogg', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'mp3', 'wav'])) {
            $fileUrl = $linkBeginning ."uploads/". $fileName;
            echo $fileUrl;
        } else {
            $fileUrl = $linkBeginning . "download.php?file=" . $fileName;
            echo $fileUrl;
        }
    } else {
        echo "ERROR: Sorry, there was an error uploading your file.";
    }
}
