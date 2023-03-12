<?php
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
        <a href="index.html" style="text-decoration: none;" id="page-name">
            <h1 id="page-name">File Upload</h1>
        </a>
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

        $link_address = file_get_contents('php/link_address.txt');
        $max_size = file_get_contents('php/max_size.txt') / 1000000;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['save_link_address'])) {
                $link_address = $_POST['link_address'];
                file_put_contents('php/link_address.txt', $link_address);
            }

            if (isset($_POST['save_max_size'])) {
                $max_size = $_POST['max_size'];
                file_put_contents('php/max_size.txt', $max_size * 1000000);
            }
        } else {
            if (file_exists('php/link_address.txt')) {
                $link_address = file_get_contents('php/link_address.txt');
            }

            if (file_exists('php/max_size.txt')) {
                $max_size = file_get_contents('php/max_size.txt') / 1000000;
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
        <form method="post">
            <label for="max_size">Max File Size (MB):</label>
            <input type="text" name="max_size" id="max_size" value="<?= htmlspecialchars($max_size, ENT_QUOTES); ?>" pattern="[0-9]+">
            <input type="submit" name="save_max_size" value="Save">
        </form>
    </div>
    <div id="success-popup"></div>
    <div id="error-popup"></div>
    <script type="text/javascript" src="js/settings.js"></script>
    <script type="text/javascript" src="js/logout.js"></script>
</body>

</html>