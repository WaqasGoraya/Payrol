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
      background: #007bff;
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
    <form action="portal.html" method="post">
      <div class="mb-3">
        <label for="employeeCode" class="form-label">Employee Code</label>
        <input type="text" id="employeeCode" name="employeeCode" class="form-control" required maxLength="4" />
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" id="password" name="password" class="form-control" required />
      </div>
      <button type="submit" class="btn btn-login w-100">Login</button>
    </form>
  </div>
</body>
</html>
