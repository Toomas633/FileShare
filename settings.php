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
        <?php
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
            echo '<form action="php/logout.php" method="post">';
            echo '<input type="submit" value="Logout">';
            echo '</form>';
        } else {
            header('Location: login.php');
            exit;
        }
        $link_address = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $link_address = $_POST['link_address'];
            file_put_contents('php/link_address.txt', $link_address);
        } else {
            $link_address = file_get_contents('php/link_address.txt');
        }
        ?>
        </div>
    </header>
    <h1>Settings</h1>
    <form method="post">
        <label for="link_address">Link Address:</label>
        <input type="text" name="link_address" id="link_address" value="<?php echo htmlspecialchars($link_address); ?>">
        <input type="submit" value="Save">
    </form>
    <script type="text/javascript" src="js/logout.js"></script>
</body>

</html>