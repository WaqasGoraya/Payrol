<?php 
// require_once('./sessions.php');
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      background-color: #f0f2f5;
    }
    .login-form {
      width: 100%;
      max-width: 400px;
      padding: 2rem;
      background-color: white;
      border-radius: 8px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }
    .login-form h3 {
      margin-bottom: 1.5rem;
    }
    .login-form button {
      width: 100%;
    }
    .login-form .form-control:focus {
      box-shadow: none;
    }
  </style>
</head>
<body>
  <div class="login-form">
     <!-- Alert Message -->
     <?php if (isset($_SESSION['message_type']) && isset($_SESSION['message']) && $_SESSION['message_type'] === 'error'): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $_SESSION['message']; ?>
            </div>
        <?php endif; ?>
    <h3 class="text-center">Login</h3>
    <form action="./auth.php" method="POST">
      <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input type="email" class="form-control" id="email" name="email" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
      </div>
      <button type="submit" class="btn btn-primary">Login</button>
    </form>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
