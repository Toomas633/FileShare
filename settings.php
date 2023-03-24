<?php
error_reporting(E_ALL & ~E_WARNING & ~E_DEPRECATED);
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
        $link_address = file_get_contents('db/link_address.txt');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['save_link_address'])) {
                $link_address = $_POST['link_address'];
                file_put_contents('db/link_address.txt', $link_address);
            }
        } else {
            if (file_exists('db/link_address.txt')) {
                $link_address = file_get_contents('db/link_address.txt');
            }
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
            <option value="">(GMT-12:00) International Date Line West</option>
            <option value="Pacific/Midway">(GMT-11:00) Midway Island, Samoa</option>
            <option value="Pacific/Honolulu">(GMT-10:00) Hawaii</option>
            <option value="America/Anchorage">(GMT-09:00) Alaska</option>
            <option value="America/Los_Angeles">(GMT-08:00) Pacific Time (US &amp; Canada)</option>
            <option value="America/Denver">(GMT-07:00) Mountain Time (US &amp; Canada)</option>
            <option value="America/Chihuahua">(GMT-07:00) Chihuahua, La Paz, Mazatlan</option>
            <option value="America/Phoenix">(GMT-07:00) Arizona</option>
            <option value="America/Chicago">(GMT-06:00) Central Time (US &amp; Canada)</option>
            <option value="America/Mexico_City">(GMT-06:00) Mexico City, Tegucigalpa</option>
            <option value="America/Regina">(GMT-06:00) Saskatchewan</option>
            <option value="America/Bogota">(GMT-05:00) Bogota, Lima, Quito, Rio Branco</option>
            <option value="America/New_York">(GMT-05:00) Eastern Time (US &amp; Canada)</option>
            <option value="America/Indiana/Indianapolis">(GMT-05:00) Indiana (East)</option>
            <option value="America/Halifax">(GMT-04:00) Atlantic Time (Canada)</option>
            <option value="America/Caracas">(GMT-04:00) Caracas, La Paz</option>
            <option value="America/Guyana">(GMT-04:00) Guyana</option>
            <option value="America/Santiago">(GMT-04:00) Santiago</option>
            <option value="America/St_Johns">(GMT-03:30) Newfoundland</option>
            <option value="America/Sao_Paulo">(GMT-03:00) Brasilia</option>
            <option value="America/Argentina/Buenos_Aires">(GMT-03:00) Buenos Aires, Georgetown</option>
            <option value="America/Godthab">(GMT-03:00) Greenland</option>
            <option value="America/Montevideo">(GMT-03:00) Montevideo</option>
            <option value="America/Noronha">(GMT-02:00) Mid-Atlantic</option>
            <option value="Atlantic/Cape_Verde">(GMT-01:00) Cape Verde Is.</option>
            <option value="Atlantic/Azores">(GMT-01:00) Azores</option>
            <option value="Europe/London">(GMT) Greenwich Mean Time : Dublin, Edinburgh, Lisbon, London</option>
            <option value="Africa/Casablanca">(GMT) Casablanca, Monrovia</option>
            <option value="Europe/Amsterdam">(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna</option>
            <option value="Europe/Belgrade">(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague</option>
            <option value="Europe/Brussels">(GMT+01:00) Brussels, Copenhagen, Madrid, Paris</option>
            <option value="Africa/Algiers">(GMT+01:00) West Central Africa</option>
            <option value="Europe/Sarajevo">(GMT+01:00) Sarajevo, Skopje, Warsaw, Zagreb</option>
            <option value="Africa/Lagos">(GMT+01:00) Lagos</option>
            <option value="Asia/Amman">(GMT+02:00) Amman</option>
            <option value="Europe/Athens">(GMT+02:00) Athens, Bucharest, Istanbul</option>
            <option value="Asia/Beirut">(GMT+02:00) Beirut</option>
            <option value="Africa/Cairo">(GMT+02:00) Cairo</option>
            <option value="Africa/Harare">(GMT+02:00) Harare, Pretoria</option>
            <option value="Europe/Helsinki">(GMT+02:00) Helsinki, Kyiv, Riga, Sofia, Tallinn, Vilnius</option>
            <option value="Asia/Jerusalem">(GMT+02:00) Jerusalem</option>
            <option value="Europe/Minsk">(GMT+03:00) Minsk</option>
            <option value="Africa/Johannesburg">(GMT+03:00) Johannesburg</option>
            <option value="Europe/Moscow">(GMT+03:00) Moscow, St. Petersburg, Volgograd</option>
            <option value="Asia/Kuwait">(GMT+03:00) Kuwait, Riyadh, Baghdad</option>
            <option value="Asia/Tehran">(GMT+03:30) Tehran</option>
            <option value="Asia/Muscat">(GMT+04:00) Muscat</option>
            <option value="Asia/Baku">(GMT+04:00) Baku</option>
            <option value="Asia/Yerevan">(GMT+04:00) Yerevan</option>
            <option value="Asia/Tbilisi">(GMT+04:00) Tbilisi</option>
            <option value="Asia/Kabul">(GMT+04:30) Kabul</option>
            <option value="Asia/Yekaterinburg">(GMT+05:00) Ekaterinburg</option>
            <option value="Asia/Karachi">(GMT+05:00) Karachi, Tashkent</option>
            <option value="Asia/Calcutta">(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi</option>
            <option value="Asia/Colombo">(GMT+05:30) Sri Jayawardenapura</option>
            <option value="Asia/Katmandu">(GMT+05:45) Kathmandu</option>
            <option value="Asia/Almaty">(GMT+06:00) Almaty, Novosibirsk</option>
            <option value="Asia/Dhaka">(GMT+06:00) Astana, Dhaka</option>
            <option value="Asia/Rangoon">(GMT+06:30) Yangon (Rangoon)</option>
            <option value="Asia/Bangkok">(GMT+07:00) Bangkok, Hanoi, Jakarta</option>
            <option value="Asia/Krasnoyarsk">(GMT+07:00) Krasnoyarsk</option>
            <option value="Asia/Hong_Kong">(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi</option>
            <option value="Asia/Irkutsk">(GMT+08:00) Irkutsk, Ulaan Bataar</option>
            <option value="Australia/Perth">(GMT+08:00) Perth</option>
            <option value="Australia/Eucla">(GMT+08:45) Eucla</option>
            <option value="Asia/Tokyo">(GMT+09:00) Osaka, Sapporo, Tokyo</option>
            <option value="Asia/Seoul">(GMT+09:00) Seoul</option>
            <option value="Asia/Yakutsk">(GMT+09:00) Yakutsk</option>
            <option value="Australia/Adelaide">(GMT+09:30) Adelaide</option>
            <option value="Australia/Darwin">(GMT+09:30) Darwin</option>
            <option value="Australia/Brisbane">(GMT+10:00) Brisbane</option>
            <option value="Australia/Hobart">(GMT+10:00) Hobart</option>
            <option value="Asia/Vladivostok">(GMT+10:00) Vladivostok</option>
            <option value="Australia/Lord_Howe">(GMT+10:30) Lord Howe Island</option>
            <option value="Etc/GMT-11">(GMT+11:00) Solomon Is., New Caledonia</option>
            <option value="Asia/Magadan">(GMT+11:00) Magadan</option>
            <option value="Pacific/Norfolk">(GMT+11:30) Norfolk Island</option>
            <option value="Asia/Anadyr">(GMT+12:00) Anadyr, Kamchatka</option>
            <option value="Pacific/Auckland">(GMT+12:00) Auckland, Wellington</option>
            <option value="Etc/GMT-12">(GMT+12:00) Fiji, Kamchatka, Marshall Is.</option>
            <option value="Pacific/Chatham">(GMT+12:45) Chatham Islands</option>
            <option value="Pacific/Tongatapu">(GMT+13:00) Nuku'alofa</option>
            <option value="Pacific/Kiritimati">(GMT+14:00) Kiritimati</option>
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
            if ($handle = opendir("uploads/")) {
                $count = 0;
                while (false !== ($file = readdir($handle))) {
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
                        $db = file_get_contents('db/database.json');
                        $data = json_decode($db, true);
                        $deleteTime = null;
                        $timezone = file_get_contents('db/tz.txt');
                        foreach ($data['files'] as $fileToDelete) {
                            if ($fileToDelete['name'] === $file) {
                                if (intval($fileToDelete['uploadTime']) === intval($fileToDelete['deleteTime'])) {
                                    $deleteTime = "Never";
                                    break;
                                } else {
                                    $deleteTime = $fileToDelete['deleteTime'] / 1000;
                                    $deleteTime = new DateTime("@$deleteTime");
                                    $deleteTime->setTimezone(new DateTimeZone($timezone));
                                    $deleteTime = $deleteTime->format('H:i:s d-M-Y');
                                    break;
                                }
                            } else {
                                $deleteTime = "Unknown";
                            }
                        }
                        echo "<p id='file-delete-time'>Delete time: $deleteTime</p>";
                        echo "</div>";
                        echo "<button id='download-button' onclick='downloadFile(\"$dir$file\")'><i class='fas fa-download-alt'></i></button>";
                        echo "<button class='delete' id='delete-button' onclick='confirmDelete(\"$dir$file\")'><i class='fas fa-trash-alt'></i></button>";
                        echo "</div>";
                        echo "</div>";
                        $count++;
                        if ($count % 3 == 0) {
                            echo "</div><div class='row'>";
                        }
                    }
                }
                closedir($handle);
            }
            ?>
        </div>
    </div>
    <div id="success-popup"></div>
    <div id="error-popup"></div>
    <script type="text/javascript" src="js/settings.js"></script>
    <script type="text/javascript" src="js/logout.js"></script>
</body>

</html>