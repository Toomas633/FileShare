<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $password_file = '../db/admin_password.txt';
    $stored_password = trim(file_get_contents($password_file));;
    if (password_verify($current_password, $stored_password)) {
        if ($new_password === $confirm_password) {
            file_put_contents($password_file, password_hash($new_password, PASSWORD_BCRYPT));
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
?>