<?php
// Database configuration
$host = 'localhost';
$dbname = 'payrol';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user,$pass, $dbname);

define('BASE_URL','http://localhost/payrol/');
function site_url(){
    return BASE_URL;
}