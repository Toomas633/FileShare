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
    <meta charset="UTF-8">
    <title>Settings</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/settings.css">
    <link rel="icon" type="icons/png" href="icons/fav.png">
</head>

<body>
    <header id="top-bar">
        <script type="text/javascript" src="js/deletestatus.js"></script>
        <h1 id="page-name"><a href="index.php" style="text-decoration: none;" id="page-name"><i class='fas fa-icon'></i>FileShare</a></h1>
        <?php
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
            echo '<form action="php/logout.php" method="post">';
            echo '<button type="submit" id="logout-btn"></button>';
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
        if (isset($_GET['status'])) {
            $status = htmlspecialchars($_GET['status']);
            if (!empty($status)) {
                echo '<script>';
                echo 'DisplayDeleteStatus("' . $status . '");';
                echo '</script>';
            }
        }
        ?>
        </div>
    </header>
    <div id="password-change-modal" class="modal">
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
    <div id="cleanup-log-modal" class="modal">
        <div id="cleanup-log-modal-content">
            <button class="close" id="close-cleanup-log-modal">X</button>
            <h2>Cleanup.log</h2>
            <pre id="cleanup-log-content"></pre>
        </div>
    </div>
    <div id="php-log-modal" class="modal">
        <div id="php-log-modal-content">
            <button class="close" id="close-php-log-modal">X</button>
            <h2>FileShare.log</h2>
            <pre id="php-log-content"></pre>
        </div>
    </div>
    <div id="success-popup"></div>
    <div id="error-popup"></div>
    <div id="sidebar">
        <h1>Settings</h1>
        <form method="post">
            <label for="link_address">Server Address:</label>
            <input type="text" name="link_address" id="link_address" value="<?= htmlspecialchars($link_address, ENT_QUOTES); ?>">
            <input type="submit" name="save_link_address" value="Save">
        </form>
        <label id="timezone-label" for="timezone">Select Timezone:</label>
        <select id="timezone" name="timezone">
            <option value="Pacific/Midway">SST (Samoa Standard Time)</option>
            <option value="Pacific/Honolulu">HST (Hawaii Standard Time)</option>
            <option value="America/Anchorage">AKST (Alaska Standard Time)</option>
            <option value="America/Los_Angeles">PST (Pacific Standard Time)</option>
            <option value="America/Denver"> MST (Mountain Standard Time)</option>
            <option value="America/Chicago">CST (Central Standard Time)</option>
            <option value="America/New_York">EST (Eastern Standard Time)</option>
            <option value="America/Halifax">AST (Atlantic Standard Time)</option>
            <option value="America/St_Johns">NST (Newfoundland Standard Time)</option>
            <option value="America/Sao_Paulo">BRT (Brasilia Time)</option>
            <option value="America/Noronha">GST (South Georgia Time Zone)</option>
            <option value="Atlantic/Azores">AZOST (Azores Summer Time)</option>
            <option value="Europe/London">GMT/UTC (Greenwich Mean Time / Universal Time Coordinated)</option>
            <option value="Europe/Amsterdam">CET (Central European Time)</option>
            <option value="Europe/Helsinki">EET (Eastern European Time)</option>
            <option value="Europe/Moscow">MSK (Moscow Standard Time)</option>
            <option value="Asia/Tehran">IRST (Iran Standard Time)</option>
            <option value="Asia/Tbilisi">GST (Gulf Standard Time)</option>
            <option value="Asia/Kabul">AFT (Afghanistan Time)</option>
            <option value="Asia/Karachi">PKT (Pakistan Standard Time)</option>
            <option value="Asia/Colombo"> IST (Indian Standard Time)</option>
            <option value="Asia/Almaty">ALMT (Almaty Time)</option>
            <option value="Asia/Bangkok">ICT (Indochina Time)</option>
            <option value="Asia/Hong_Kong">AWST (Australian Western Standard Time)</option>
            <option value="Australia/Eucla">ACWST (Australian Central Western Standard Time)</option>
            <option value="Asia/Tokyo">JST (Japan Standard Time)</option>
            <option value="Australia/Adelaide">ACST (Australian Central Standard Time)</option>
            <option value="Australia/Brisbane">AEST (Australian Eastern Standard Time)</option>
            <option value="Australia/Lord_Howe">ACDT (Australian Central Daylight Time)</option>
            <option value="Asia/Magadan">AEDT (Australian Eastern Daylight Time)</option>
            <option value="Pacific/Norfolk">NFT (Norfolk Island Time)</option>
            <option value="Asia/Anadyr">FJT (Fiji Time)</option>
            <option value="Pacific/Auckland">NZST (New Zealand Standard Time)</option>
            <option value="Pacific/Chatham">CHAST (Chatham Island Standard Time)</option>
        </select>
        <button id="refresh-btn" onclick="location.reload()">Refresh</button>
        <button id="change-password-btn">Change Password</button>
        <button id="phpModal-btn" onclick="openPHPModal()">FileShare.log</button>
        <button id="cleanupModal-btn" onclick="openCleanupModal()">Cleanup.log</button>
        <?php
        $repo = 'Toomas633/FileShare';
        $filepath = DIR_PATH . 'version';
        $raw_url = "https://raw.githubusercontent.com/{$repo}/main/version";
        $update_url = "https://github.com/Toomas633/FileShare/releases";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $raw_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $github_float = floatval($result);
        $file_contents = file_get_contents($filepath);
        $local_float = floatval($file_contents);
        if ($github_float > $local_float) {
            echo "<a href='{$update_url}' id='update'>Update required! Current version {$local_float}, latest {$github_float}</a>";
        } else {
            echo "<p id='version'>v{$local_float}</p>";
        }
        ?>
    </div>
    <button id="toggle-sidebar"></button>
    <div id="file-list">
        <h2>List of Files</h2>
        <div class="warning"></div>
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
                                echo "<img src='uploads/$file' class='file-preview'>";
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
    <script type="text/javascript" src="js/settings.js"></script>
    <script type="text/javascript" src="js/logout.js"></script>
</body>

</html>