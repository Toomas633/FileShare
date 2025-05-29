<?php
require_once 'cleanup.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download</title>
    <link rel="stylesheet" type="text/css" href="css/download.css">
    <link rel="icon" type="icons/png" href="icons/fav.png">
</head>

<body>
    <header id="top-bar">
        <h1 id="page-name"><a href="index.php" style="text-decoration: none;" id="page-name"><i class='fas fa-icon'></i>FileShare</a></h1>
        <a href="login.php" id="login-button"><i class="fa-settings"></i></a>
    </header>
    <?php
    require_once 'config.php';
    if (isset($_GET['file'])) {
        $file = $_GET['file'];
        $status = $_GET['status'];
        if ($status !== null) {
            echo '<div id="error-popup">';
            echo "<p id='link-error'>$status</p>";
            echo "</div>";
        }
        $folder = DIR_PATH . "uploads/";
        $file_found = false;
        $dir = new DirectoryIterator($folder);
        foreach ($dir as $fileinfo) {
            if ($fileinfo->isFile() && $fileinfo->getFilename() == $file) {
                $file_found = true;
                $file_path = $fileinfo->getPathname();
                break;
            }
        }
        if ($file_found) {
            echo '<div id="found-file">';
            include_once "php/icons.php";
            echo "<div class='text-container'>";
            echo "<p id='file-name'>$file</p>";
            $pdo = new PDO('sqlite:' . DB_FILE);
            $query = $pdo->prepare('SELECT value FROM settings WHERE setting = :setting');
            $query->bindValue(':setting', 'timezone', PDO::PARAM_STR);
            $query->execute();
            $row = $query->fetch(PDO::FETCH_ASSOC);
            $timezone = $row['value'];
            $query = $pdo->prepare('SELECT * FROM files');
            $query->execute();
            $data = $query->fetchAll(PDO::FETCH_ASSOC);
            $pdo = null;
            $deleteTime = null;
            if (count($data) == 0) {
                $deleteTime = "Unknown";
            } else {
                foreach ($data as $fileToDelete) {
                    if ($fileToDelete['name'] === $file) {
                        if (intval($fileToDelete['uploadTime']) === intval($fileToDelete['deleteTime'])) {
                            $deleteTime = "Never";
                            break;
                        } else {
                            $deleteTime = (float) $fileToDelete['deleteTime'] / 1000;
                            $deleteTime = DateTime::createFromFormat('U.u', sprintf('%.6f', $deleteTime));
                            $deleteTime->setTimezone(new DateTimeZone($timezone));
                            $deleteTime = $deleteTime->format('H:i:s d-M-Y');
                            break;
                        }
                    } else {
                        $deleteTime = "Unknown";
                    }
                }
            }
            echo "<p id='file-delete-time'>Delete time: $deleteTime ( Server timezone: $timezone )</p>";
            echo "</div>";
            echo "<button id='download-button' onclick='downloadFile(\"$file\")'><i class='fas fa-download-alt'></i></button>";
            echo "<button class='delete' id='delete-button' onclick='confirmDelete(\"$file\")'><i class='fas fa-trash-alt'></i></button>";
            echo "</div>";
        } else {
            echo '<div id="error-popup">';
            echo "<p id='link-error'>Error: File not found.</p>";
            echo "</div>";
        }
    } else {
        echo '<div id="error-popup">';
        echo "<p id='link-error'>Error: Invalid download link.</p>";
        echo "</div>";
    }
    $pdo = null;
    ?>
    <script type="text/javascript" src="js/download.js"></script>
    <script type="text/javascript" src="js/logout.js"></script>
</body>

</html>
