<?php require('../connection/conn.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #007bff;
            color: white;
            border-bottom: none;
            border-radius: 15px 15px 0 0;
        }

        .card-body {
            text-align: center;
        }

        .card-body a {
            text-decoration: none;
        }

        .card-body a.btn {
            width: 100%;
            padding: 10px;
            font-size: 1.1rem;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1 class="mb-4">Manage Leaves</h1>
                <p class="lead">Manage your Leaves Types and Leave Requests</p>
                <!-- Heading and Dashboard Button -->

                <a href="<?= site_url() ?>dashboard.php" class="btn btn-success mb-3">Go to Dashboard</a>

            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card text-white bg-info mb-3">
                    <div class="card-body text-center">
                        <h5 class="card-title">Leave Requests</h5>
                        <p class="card-text">Manage your leave requests here.view request details.</p>
                        <a href="leave_request.php" class="btn btn-light btn-sm">Go to Requests</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body text-center">
                        <h5 class="card-title">Leave Types</h5>
                        <p class="card-text">Manage different types of leaves. Add new types or edit existing ones.</p>
                        <a href="leave_types.php" class="btn btn-light">Go to Leave Types</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>