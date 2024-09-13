<?php
// include database connection
require_once('../connection/conn.php');

// Fetch leave type data from database
// Fetch leave type ID from URL
if (isset($_GET['id'])) {
    $leave_type_id = intval($_GET['id']); // Sanitize the ID input

    // Fetch leave type data from database using raw SQL query
    $query = "SELECT name FROM leave_types WHERE id = $leave_type_id";
    $result = mysqli_query($conn,$query);

    if ($result) {
        $leave_type = $result->fetch_assoc();
        $leave_type_name = $leave_type['name'] ?? '';
        $result->free();
    } else {
        echo "Error: " . $mysqli->error;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Leave Type</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                Edit Leave Type
                <a href="<?= site_url() ?>leaves/leave_types.php" class="btn btn-light btn-sm">Back to List</a>
            </div>
            <div class="card-body">
                <form action="../form_handler.php" method="POST">
                    <input type="hidden" name="form_type" value="update_leave_type">
                    <input type="hidden" name="leave_type_id" value="<?= htmlspecialchars($leave_type_id) ?>">
                    <div class="mb-3">
                        <label for="leave_type_name" class="form-label">Leave Type</label>
                        <input type="text" class="form-control" id="leave_type_name" name="leave_type_name" value="<?= htmlspecialchars($leave_type_name) ?>" required>
                    </div>
                    <button type="submit" class="btn btn-success">Update</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
