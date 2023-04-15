<?php
require_once('config.php');
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>FileShare</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="css/index.css">
  <link rel="icon" type="icons/png" href="icons/fav.png">
</head>

<body>
  <header id="top-bar">
    <h1 id="page-name">
      <a href="index.php" style="text-decoration: none" id="page-name">FileShare</a>
    </h1>
    <a href="login.php" id="login-button"><i class="fa-settings"></i></a>
  </header>
  <div id="file-upload-form">
    <h2>Upload a File</h2>
    <form id="upload-form" enctype="multipart/form-data">
      <div id="drop-area">
        <p>Drag and drop a file here or click to select a file</p>
        <input id="file-upload" type="file"/>
        <div id="file-name"></div>
        <?php
        $size = ini_get('upload_max_filesize');
        echo '<p id="max-file-size">(Max size: ' . $size . ')</p>';
        ?>
      </div>
      <div id="random">
        <label id="random-lable" for="random-toggle-switch">Random name:</label>
        <label class="random-switch">
          <input type="checkbox" id="random-toggle-switch" />
          <span id="random-switch-value"></span>
        </label>
      </div>
      <div id="direct">
        <label id="direct-lable" for="direct-toggle-switch">Direct link:</label>
        <label class="direct-switch">
          <input type="checkbox" id="direct-toggle-switch" />
          <span id="direct-switch-value"></span>
        </label>
      </div>
      <div id="slider-container">
        <label for="delete-time-slider">Delete Time:</label>
        <input type="range" id="delete-time-slider" name="delete-time-slider" min="0" max="13" step="1" value="0" />
        <span id="slider-value">Never</span>
      </div>
      <button type="submit" id="upload-button">Upload File</button>
    </form>
  </div>
  <div id="link-popup">
    <span class="close">&times;</span>
    <h2>File Upload Complete</h2>
    <p>Your file has been uploaded. Here is the link:</p>
    <input type="text" id="link" readonly />
    <button id="copy-link-button">
      <i class="fa-clipboard"></i>Copy Link
    </button>
  </div>
  <div id="error-popup">
    <span class="close">&times;</span>
    <h2>File Upload Error</h2>
    <input type="text" id="error" readonly />
  </div>
  <div id="upload-status" style="display:none;">
    <div id="progress-bar"></div>
    <div id="status-message"></div>
  </div>
  <script type="text/javascript" src="js/index.js"></script>
  <script type="text/javascript" src="js/logout.js"></script>
</body>

</html>