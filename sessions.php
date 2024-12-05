<?php
session_start(); // Start the session


// Set session timeout duration (e.g., 10 seconds for messages)
$timeout_duration = 10;

// Unset specific session variables (e.g., message-related) after the timeout duration
if (isset($_SESSION['LAST_ACTIVITY'])) {
    $elapsed_message_time = time() - $_SESSION['LAST_ACTIVITY'];

    if ($elapsed_message_time > $timeout_duration) {
        // Unset specific message-related session variables
        unset($_SESSION['message']);
        unset($_SESSION['message_type']);
        
        // Unset the message time tracking session
        unset($_SESSION['LAST_ACTIVITY']);
    }
}

// This part is only for the logged-in session, independent of message sessions
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: https://my.petrofastme.com/employee/login.php");
    exit;
}

// Update the last activity time to the current time
$_SESSION['LAST_ACTIVITY'] = time();

?>
