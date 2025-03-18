<?php
require_once 'config/db.php';

// Sanitize Input
function sanitize($data) {
    global $conn;
    return htmlspecialchars(mysqli_real_escape_string($conn, trim($data)));
}
?>
