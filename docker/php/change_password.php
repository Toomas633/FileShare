<?php
require_once('../config.php');
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo = new PDO('sqlite:' . DB_FILE2);
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $query = $pdo->prepare('SELECT value FROM settings WHERE setting = :setting');
    $query->bindValue(':setting', 'password', PDO::PARAM_STR);
    $query->execute();
    $row = $query->fetch(PDO::FETCH_ASSOC);
    $stored_password = $row['value'];
    $pdo = null;
    if (password_verify($current_password, $stored_password)) {
        if ($new_password === $confirm_password) {
            $pdo = new PDO('sqlite:' . DB_FILE2);
            $query = $pdo->prepare('UPDATE settings SET value = :new_value WHERE setting = :setting');
            $query->bindValue(':new_value', password_hash($new_password, PASSWORD_BCRYPT), PDO::PARAM_STR);
            $query->bindValue(':setting', 'password', PDO::PARAM_STR);
            $query->execute();
            $pdo = null;
            echo json_encode(array('status' => 'success', 'message' => 'Password changed successfully.'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'New password and confirm password do not match.'));
        }
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Current password is incorrect.'));
    }
} else {
    header('Location: ../settings.php');
    exit;
}
