<?php
session_start();
include('./connection/conn.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $employee_code = $_POST['employeeCode'];
    $password = $_POST['password'];

    // Validate input
    if (empty($employee_code) || empty($password)) {
      $_SESSION['message_type'] = 'danger';
        $_SESSION['message'] = 'Employee code or password cannot be empty!';
        header("Location: {$_SERVER['HTTP_REFERER']}"); // Redirects back to the previous page
        exit;
    }

    // Check if the employee exists in the database
    $sql = "SELECT * FROM employee WHERE employee_code = $employee_code";
    $stmt = $conn->query($sql);
    $employee = $stmt->fetch_assoc();

    if ($stmt->num_rows > 0 ) {
      if(password_verify($password, $employee['password'])){
        // Password matches, login successful
        $_SESSION['employee_id'] = $employee['id'];
        $_SESSION['employee_code'] = $employee['employee_code'];

        // Redirect to dashboard
        header("Location: emp_portal.php");
        exit;
      }else{
        $_SESSION['message_type'] = 'danger';
        $_SESSION['message'] = 'Invalid employee code or password.!';
        header("Location: {$_SERVER['HTTP_REFERER']}"); // Redirects back to the previous page
        exit;
      }
    } else {
      $_SESSION['message_type'] = 'danger';
        $_SESSION['message'] = 'Invalid employee code or password.!';
        header("Location: {$_SERVER['HTTP_REFERER']}"); // Redirects back to the previous page
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Employee Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #007bff, #0056b3);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      color: white;
    }
    .login-container {
      background: white;
      color: #333;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
      max-width: 400px;
      width: 100%;
    }
    .login-container h1 {
      text-align: center;
      margin-bottom: 20px;
    }
    .btn-login {
      /* background: #; */
      color: white;
    }
    .btn-login:hover {
      background: #0056b3;
    }
  </style>
</head>
<body>
  <div class="login-container">
    <h1>Employee Login</h1>
    <?php
        
        if (isset($_SESSION['message'])) {
            $messageType = $_SESSION['message_type'] ?? 'info';
            echo "<div class='alert alert-$messageType text-center'>{$_SESSION['message']}</div>";
            unset($_SESSION['message'], $_SESSION['message_type']); // Clear the message after displaying it
        }
        ?>
    <form action="emp_login.php" method="post">
      <div class="mb-3">
        <label for="employeeCode" class="form-label">Employee Code</label>
        <input type="text" id="employeeCode" name="employeeCode" class="form-control" required maxLength="4" />
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" id="password" name="password" class="form-control" required />
      </div>
      <button type="submit" class="btn btn-success w-100">Login</button>
    </form>
  </div>
</body>
</html>
