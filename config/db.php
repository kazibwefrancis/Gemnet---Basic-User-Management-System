<?php
$host = 'localhost';
$dbname = 'user_management';
$username = 'root';
$password = '';

// Establish Database Connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check Connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
