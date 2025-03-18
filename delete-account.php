<?php
require_once 'config/auth.php';
require_once 'includes/functions.php';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Get user profile picture
    $stmt = $conn->prepare("SELECT profile_picture FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($profile_picture);
    $stmt->fetch();
    $stmt->close();

    // Delete profile picture file
    if (file_exists($profile_picture)) {
        unlink($profile_picture);
    }

    // Delete user data
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    session_destroy();
    header("Location: index.php");
}
?>
