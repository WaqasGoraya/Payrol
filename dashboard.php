<?php  require_once('./sessions.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1 class="mb-4">Admin Dashboard</h1>
                <p class="lead">Manage your application easily with these options</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body text-center">
                        <h5 class="card-title">Employees</h5>
                        <p class="card-text">Manage employee records</p>
                        <a href="employees/employees.php" class="btn btn-light">Go to Employees</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body text-center">
                        <h5 class="card-title">Departments</h5>
                        <p class="card-text">Manage department details</p>
                        <a href="departments/department.php" class="btn btn-light">Go to Departments</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-body text-center">
                        <h5 class="card-title">Document Types</h5>
                        <p class="card-text">Manage document types</p>
                        <a href="documents/documents.php" class="btn btn-light">Go to Document Types</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card text-white bg-danger mb-3">
                    <div class="card-body text-center">
                        <h5 class="card-title">Salary Types</h5>
                        <p class="card-text">Manage salary types</p>
                        <a href="salaries/salaries.php" class="btn btn-light">Go to Salary Types</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-info mb-3">
                    <div class="card-body text-center">
                        <h5 class="card-title">Locations</h5>
                        <p class="card-text">Manage location details</p>
                        <a href="locations/location.php" class="btn btn-light">Go to Locations</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-dark mb-3">
                    <div class="card-body text-center">
                        <h5 class="card-title">Leave Request</h5>
                        <p class="card-text">Manage leaves request</p>
                        <a href="leaves/leaves.php" class="btn btn-light">Go to Leaves</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS (optional for any Bootstrap JS components) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
