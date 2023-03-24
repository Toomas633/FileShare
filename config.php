<?php
define('DB_FILE', 'db/database.db');
ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_WARNING & ~E_DEPRECATED);

try {
    $pdo = new PDO('sqlite:' . DB_FILE);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Connection failed: ' . $e->getMessage());
}