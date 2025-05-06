<?php

session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../user/login.php");
    exit();
}
function is_logged_in() {
    return isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true;
}

function is_admin() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

function require_admin() {
    session_start();
    if (!is_logged_in() || !is_admin()) {
        header("Location: ../login.php");
        exit();
    }
}
function redirect($url) {
    header("Location: $url");
    exit();
}
?>
