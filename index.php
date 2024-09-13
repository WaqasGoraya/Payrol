<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome to Payroll System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body, html {
      height: 100%;
      margin: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      background-color: #f8f9fa;
    }

    .content-wrapper {
      text-align: center;
      max-width: 600px;
    }

    h1 {
      font-size: 3rem;
      font-weight: bold;
      margin-bottom: 20px;
      color: #333;
    }

    p {
      font-size: 1.25rem;
      color: #666;
      margin-bottom: 30px;
    }

    .btn-login {
      background-color: #007bff;
      color: white;
      padding: 15px 30px;
      font-size: 1.25rem;
      border: none;
      border-radius: 30px;
      transition: background-color 0.3s ease;
    }

    .btn-login:hover {
      background-color: #0056b3;
    }

    /* Optional footer (can be removed) */
    .footer {
      position: fixed;
      bottom: 20px;
      left: 50%;
      transform: translateX(-50%);
      font-size: 0.875rem;
      color: #aaa;
    }
  </style>
</head>
<body>

  <div class="content-wrapper">
    <h1>Welcome to Payroll Management</h1>
    <p>Manage your payroll with ease and efficiency. Log in to access your account and stay on top of employee management.</p>
    <a href="login.php" class="btn btn-login">Log In</a>
  </div>

  <div class="footer">
    &copy; 2024 Payroll Management
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
