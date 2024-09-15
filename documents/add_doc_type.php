<?php 
require_once('../sessions.php');
require('../connection/conn.php'); 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Document Type</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                Add Document Type
                <a href="<?= site_url() ?>documents/documents.php" class="btn btn-light btn-sm">Back to List</a>
            </div>
            <div class="card-body">

                <form action="../form_handler.php" method="POST">
                    <input type="hidden" name="form_type" value="doc_type">
                    <div class="mb-3">
                        <label for="doc_type_name" class="form-label">Document Type</label>
                        <input type="text" class="form-control" id="doc_type_name" name="doc_type_name" required>
                    </div>
                    <button type="submit" class="btn btn-success">Submit</button>
                </form>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>