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

$sql = "CREATE TABLE settings (
    password TEXT NOT NULL,
    url TEXT NOT NULL,
    timezone TEXT NOT NULL
)";

// Execute the SQL statement to create the table
try {
$pdo->exec($sql);
echo "Table 'users' created successfully.";
} catch (PDOException $e) {
die("Table creation failed: " . $e->getMessage());
}