<?php
if (isset($_COOKIE['user_email'])) {
    $_SESSION['user_email'] = $_COOKIE['user_email'];
}
?>
