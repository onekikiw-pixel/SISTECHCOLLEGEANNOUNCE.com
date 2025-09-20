<?php
session_start();
require_once 'db.php';

function is_logged_in() {
    return !empty($_SESSION['user_id']);
}

function require_login() {
    if (!is_logged_in()) {
        header('Location: login.php');
        exit;
    }
}

function current_user() {
    global $mysqli;
    if (!is_logged_in()) return null;
    $id = intval($_SESSION['user_id']);
    $stmt = $mysqli->prepare('SELECT id, username, display_name FROM users WHERE id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $res = $stmt->get_result();
    return $res->fetch_assoc();
}
?>