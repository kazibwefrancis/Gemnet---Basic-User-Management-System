<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'db.php';

// Check if User is Logged In
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Redirect to Login if Not Logged In
function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: login.php");
        exit();
    }
}
?>
