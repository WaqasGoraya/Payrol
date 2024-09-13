<?php
// require_once('./sessions.php');
require_once('./db_conn.php');

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    exit('waqas');
    // Escaping user inputs for security
    $email = $conn->real_escape_string($email);
    $password = $conn->real_escape_string($password);

    // Raw SQL query to check if the user exists
    $sql = "SELECT * FROM auth WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Store session variables
            $_SESSION['loggedin'] = true;
            $_SESSION['email'] = $user['email'];
            header("Location:" .BASE_URL. "dashboard.php"); // Redirect to dashboard
            exit;
        } else {
            $_SESSION['message_type'] = 'error';
            $_SESSION['message'] = 'Invalid email or password.';
            header('Location:' .BASE_URL. 'login.php');
            exit;
        }
    } else {
        $_SESSION['message_type'] = 'error';
        $_SESSION['message'] = 'Invalid email or password.';
        header('Location:' .BASE_URL. 'login.php');
        exit;
    }
}
?>
