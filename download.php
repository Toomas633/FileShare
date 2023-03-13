<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <title>File Upload</title>
    <link rel="stylesheet" type="text/css" href="css/download.css" />
    <link rel="icon" type="icons/png" href="icons/fav.png">
</head>

<body>
    <header id="top-bar">
        <h1 id="page-name"><a href="index.html" style="text-decoration: none;" id="page-name">File Upload</a></h1>
        <a href="login.php" id="login-button"><i class="fa-settings"></i></a>
    </header>
    <?php
    if (isset($_GET['file'])) {
        $fileName = $_GET['file'];
    } else {
        echo '<div id="error-popup">';
        echo "<p id='link-error'>Error: File name not specified.</p>";
        echo "</div>";
    }
    ?>
    <script type="text/javascript" src="js/download.js"></script>
    <script type="text/javascript" src="js/logout.js"></script>
</body>

</html>