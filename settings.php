<?php
require_once('config.php');
session_set_cookie_params(0);
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Settings</title>
    <link rel="stylesheet" type="text/css" href="css/settings.css" />
    <link rel="icon" type="icons/png" href="icons/fav.png">
</head>
<body>
    <header id="top-bar">
        <h1 id="page-name"><a href="index.php" style="text-decoration: none;" id="page-name">FileShare</a></h1>
        <button id="change-password-btn">Change Password</button>
        <?php
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
            echo '<form action="php/logout.php" method="post">';
            echo '<input type="submit" id="logout-btn" value="Logout">';
            echo '</form>';
        } else {
            header('Location: login.php');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['save_link_address'])) {
                $link_address = $_POST['link_address'];
                $pdo = new PDO('sqlite:' . DB_FILE);
                $query = $pdo->prepare('UPDATE settings SET value = :new_value WHERE setting = :setting');
                $query->bindValue(':new_value', $link_address, PDO::PARAM_STR);
                $query->bindValue(':setting', 'url', PDO::PARAM_STR);
                $query->execute();
                $pdo = null;
            }
        } else {
            $pdo = new PDO('sqlite:' . DB_FILE);
            $query = $pdo->prepare('SELECT value FROM settings WHERE setting = :setting');
            $query->bindValue(':setting', 'url', PDO::PARAM_STR);
            $query->execute();
            $row = $query->fetch(PDO::FETCH_ASSOC);
            $link_address = $row['value'];
            $pdo = null;
        }
        ?>
        </div>
    </header>
    <div id="password-change-modal">
        <div id="password-change-modal-content">
            <button class="close" id="close-password-modal">X</button>
            <h2>Change Password</h2>
            <form action="php/change_password.php" method="post">
                <label for="current-password">Current Password:</label>
                <input type="password" id="current-password" name="current_password"><br><br>
                <label for="new-password">New Password:</label>
                <input type="password" id="new-password" name="new_password"><br><br>
                <label for="confirm-password">Confirm Password:</label>
                <input type="password" id="confirm-password" name="confirm_password"><br><br>
                <input type="submit" value="Save">
            </form>
        </div>
    </div>
    <div id="sidebar">
        <h1>Settings</h1>
        <form method="post">
            <label for="link_address">Server Address:</label>
            <input type="text" name="link_address" id="link_address" value="<?= htmlspecialchars($link_address, ENT_QUOTES); ?>">
            <input type="submit" name="save_link_address" value="Save">
        </form>
        <label id="timezone-label" for="timezone">Select Timezone:</label>
        <select id="timezone" name="timezone">
            <option value='UTC'>UTC</option>
            <option value='GMT-12'>UTC-12:00 International Date Line West (IDLW)</option>
            <option value='GMT-11'>UTC-11:00 Samoa Standard Time (SST)</option>
            <option value='GMT-10'>UTC-10:00 Hawaii-Aleutian Standard Time (HST)</option>
            <option value='GMT-9'>UTC-9:00 Alaska Standard Time (AKST)</option>
            <option value='GMT-8'>UTC-8:00 Pacific Standard Time (PST)</option>
            <option value='GMT-7'>UTC-7:00 Mountain Standard Time (MST)</option>
            <option value='GMT-6'>UTC-6:00 Central Standard Time (CST)</option>
            <option value='GMT-5'>UTC-5:00 Eastern Standard Time (EST) </option>
            <option value='GMT-4'>UTC-4:00 Atlantic Standard Time (AST)</option>
            <option value='GMT-3'>UTC-3:00 Brasilia Time (BRT)</option>
            <option value='GMT-2'>UTC-2:00 South Georgia Time (GST)</option>
            <option value='GMT-1'>UTC-1:00 Azores Time (AZOT)</option>
            <option value='GMT 1'>UTC+1:00</option>
            <option value='GMT 2'>UTC+2:00</option>
            <option value='GMT 3'>UTC+3:00</option>
            <option value='GMT 4'>UTC+4:00</option>
            <option value='GMT 5'>UTC+5:00</option>
            <option value='GMT 6'>UTC+6:00</option>
            <option value='GMT 7'>UTC+7:00</option>
            <option value='GMT 8'>UTC+8:00</option>
            <option value='GMT 9'>UTC+9:00</option>
            <option value='GMT 10'>UTC+10:00</option>
            <option value='GMT 11'>UTC+11:00</option>
            <option value='GMT 12'>UTC+12:00</option>
        </select>
        <button id="refresh-btn" onclick="location.reload()">Refresh</button>
    </div>
    <div id="file-list">
        <h2>List of Files</h2>
        <div class="warning"></div>
        <?php
        if (isset($_GET['status'])) {
            echo "<p class='warning'>" . htmlspecialchars($_GET['status']) . "</p>";
        }
        ?>
        <div class="row">
            <?php
            $dir = DIR_PATH . "uploads/";
            if ($handler = opendir($dir)) {
                $count = 0;
                while (false !== ($file = readdir($handler))) {
                    if ($file != "." && $file != "..") {
                        $extension = pathinfo($file, PATHINFO_EXTENSION);
                        echo "<div class='col'>";
                        echo "<div class='file'>";
                        switch ($extension) {
                            case "jpg":
                            case "jpeg":
                            case "png":
                            case "gif":
                            case "bmp":
                            case "webp":
                                echo "<img src='icons/image-icon.png' class='file-preview'>";
                                break;
                            case "pdf":
                                echo "<img src='icons/pdf-icon.png' class='file-preview'>";
                                break;
                            case "doc":
                            case "docx":
                                echo "<img src='icons/doc-icon.png' class='file-preview'>";
                                break;
                            case "txt":
                                echo "<img src='icons/txt-icon.png' class='file-preview'>";
                                break;
                            case "xlsx":
                            case "csv":
                                echo "<img src='icons/excel-icon.png' class='file-preview'>";
                                break;
                            case "pptx":
                                echo "<img src='icons/powerpoint-icon.png' class='file-preview'>";
                                break;
                            case "zip":
                                echo "<img src='icons/zip-icon.png' class='file-preview'>";
                                break;
                            case "rar":
                                echo "<img src='icons/rar-icon.png' class='file-preview'>";
                                break;
                            case "mp4 webm ogg":
                            case "webm":
                            case "ogg":
                            case "mkv":
                                echo "<img src='icons/video-icon.png' class='file-preview'>";
                                break;
                            case "wav":
                            case "mp3":
                                echo "<img src='icons/audio-icon.png' class='file-preview'>";
                                break;
                            default:
                                echo "<img src='icons/file-icon.png' class='file-preview'>";
                        }
                        echo "<div class='text-container'>";
                        echo "<a href='download.php?file=$file' id='file-name'>$file</a>";
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
                                        $deleteTime = (float) intval($fileToDelete['deleteTime']) / 1000;
                                        $deleteTime = DateTime::createFromFormat('U.u', sprintf('%.6f', $deleteTime ));
                                        $deleteTime->setTimezone(new DateTimeZone($timezone));
                                        $deleteTime = $deleteTime->format('H:i:s d-M-Y');
                                        break;
                                    }
                                } else {
                                    $deleteTime = "Unknown";
                                }
                            }
                        }
                        echo "<p id='file-delete-time'>Delete time: $deleteTime</p>";
                        echo "</div>";
                        echo "<button id='download-button' onclick='downloadFile(\"$file\")'><i class='fas fa-download-alt'></i></button>";
                        echo "<button class='delete' id='delete-button' onclick='confirmDelete(\"$file\")'><i class='fas fa-trash-alt'></i></button>";
                        echo "</div>";
                        echo "</div>";
                        $count++;
                        if ($count % 3 == 0) {
                            echo "</div><div class='row'>";
                        }
                    }
                }
                closedir($handler);
            }
            $pdo = null;
            ?>
        </div>
    </div>
    <div id="success-popup"></div>
    <div id="error-popup"></div>
    <script type="text/javascript" src="js/settings.js"></script>
    <script type="text/javascript" src="js/logout.js"></script>
</body>
</html>