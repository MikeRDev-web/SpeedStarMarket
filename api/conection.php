<?php
$serverName = 'localhost';
$username = 'mike';
$password = 'mangeL.123';
$dbName = 'motor_finder';

$conn = new mysqli($serverName, $username, $password, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>