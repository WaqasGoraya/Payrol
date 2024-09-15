<?php
session_start();
require_once('./db_conn.php');
session_destroy();
header('Location:' .BASE_URL);
exit;
?>
