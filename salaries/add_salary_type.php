<?php 
require_once('../sessions.php');
require('../connection/conn.php'); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Salary Type</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            Add Salary Type
            <a href="<?= site_url() ?>salaries/salaries.php" class="btn btn-light btn-sm">Back to List</a>
        </div>
        <div class="card-body">
            <form action="../form_handler.php" method="POST">
                <input type="hidden" name="form_type" value="salary_type">
                <div class="mb-3">
                    <label for="salary_type_name" class="form-label">Salary Type</label>
                    <input type="text" class="form-control" id="salary_type_name" name="salary_type_name" required>
                </div>
                <button type="submit" class="btn btn-success">Submit</button>
            </form>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
