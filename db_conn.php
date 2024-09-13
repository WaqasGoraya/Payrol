<?php
// Database configuration
$host = 'localhost';
$dbname = 'payrol';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user,$pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

define('BASE_URL','http://localhost/payrol/');
?>