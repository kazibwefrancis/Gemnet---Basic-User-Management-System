<?php
require_once 'config/auth.php';
requireLogin();
require_once 'includes/header.php';
?>

<h2>Welcome to Your Dashboard</h2>
<a href="edit-profile.php">Edit Profile</a>
<a href="delete-account.php">Delete Account</a>

<?php require_once 'includes/footer.php'; ?>
