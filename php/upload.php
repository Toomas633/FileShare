<?php
$targetDir = "../uploads/";
$extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
$fileName = uniqid() . '.' . $extension;
$targetFile = $targetDir . $fileName;
$uploadOk = 1;
$errorMsg = "";
$imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

// Read the beginning of the generated link and max file size from a file
$linkBeginning = file_get_contents("link_address.txt");
$maxFileSize = intval(file_get_contents("max_size.txt"));

// Check if file already exists
if (file_exists($targetFile)) {
    $errorMsg = "ERROR: Sorry, file already exists.";
    $uploadOk = 0;
}

// Check file size
if (isset($maxFileSize)) {
    if ($_FILES["file"]["size"] > $maxFileSize) {
        $errorMsg = "ERROR: Sorry, your file is too large.";
        $uploadOk = 0;
    }
} else {
    $errorMsg = "ERROR: Max file size not set or file unavailable.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo $errorMsg;

    // if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
        if (in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'mp4', 'webm', 'ogg', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'])) {
            $fileUrl = $linkBeginning . $fileName;
            echo $fileUrl;
        } else {
            $fileUrl = $linkBeginning . "download.php/" . $fileName;
            echo $fileUrl;
        }
    } else {
        echo "ERROR: Sorry, there was an error uploading your file.";
    }
}
