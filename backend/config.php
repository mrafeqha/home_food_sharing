<?php
session_start();
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'home_food';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die('Database connection failed');
}
$conn->set_charset('utf8mb4');

function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function redirect($path) {
    header('Location: ' . $path);
    exit;
}
?>

