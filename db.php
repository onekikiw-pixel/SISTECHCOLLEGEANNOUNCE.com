<?php
// db.php - configure your DB credentials here
$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'school_announcements';

$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($mysqli->connect_errno) {
    die('Database connection failed: ' . $mysqli->connect_error);
}
$mysqli->set_charset('utf8mb4');
?>