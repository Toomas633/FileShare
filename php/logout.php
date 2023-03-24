<?php
session_set_cookie_params(0);
session_start(); // Start a session
$_SESSION["logged_in"] = false; // Unset the session variable
session_destroy();
header('Location: ../index.php');
