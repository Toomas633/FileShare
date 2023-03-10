<?php
$targetDir = "../uploads/";
$targetFile = $targetDir . basename($_FILES["file"]["name"]);
$uploadOk = 1;
$errorMsg = "";
$imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

// Read the beginning of the generated link from a file
$linkBeginning = file_get_contents("link_address.txt");

// Check if file already exists
if (file_exists($targetFile)) {
    $errorMsg = "ERROR: Sorry, file already exists.";
    $uploadOk = 0;
}

// Check file size
if ($_FILES["file"]["size"] > 5000000) {
    $errorMsg = "ERROR: Sorry, your file is too large.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo $errorMsg;

    // if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
        $fileUrl = $linkBeginning . "uploads/" . basename($_FILES["file"]["name"]);
        echo $fileUrl;
    } else {
        echo "ERROR: Sorry, there was an error uploading your file.";
    }
}
?>