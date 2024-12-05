<?php
// Start session and include database connection
require_once('../connection/conn.php');
require_once('../sessions.php');

// Fetch leave types from database
$sql = "SELECT * FROM leave_types";
$leave_types = $conn->query($sql);

// Handle delete request
$delete_id = $_GET['delete_id'] ?? '';

if ($delete_id) {
    $sql = "DELETE FROM leave_types WHERE id = $delete_id";
    $result = mysqli_query($conn,$sql);
    if($result){
    $_SESSION['message'] = 'Leave type deleted successfully.';
    $_SESSION['message_type'] = 'success';
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
} else {
    echo "Error deleting salary type: " . mysqli_error($conn);
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Types</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <!-- Heading and Dashboard Button -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Leaves Types</h2>
            <a href="<?= site_url()?>leaves/leaves.php" class="btn btn-primary">Go to Leaves Dashboard</a>
        </div>
        <!-- Alert Message -->
        <?php if(isset($_SESSION['message_type']) && isset($_SESSION['message']) && $_SESSION['message_type'] === 'success'): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $_SESSION['message']; ?>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
                Leave Types
                <a href="add_leave_type.php" class="btn btn-light btn-sm">Add New</a>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Leave Type</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($leave_types): ?>
                            <?php foreach ($leave_types as $leave_type): ?>
                                <tr>
                                    <td><?= htmlspecialchars($leave_type['id']) ?></td>
                                    <td><?= htmlspecialchars($leave_type['name']) ?></td>
                                    <td>
                                        <a href="edit_leave_type.php?id=<?= htmlspecialchars($leave_type['id']) ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="?delete_id=<?= htmlspecialchars($leave_type['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirmDelete();">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="3" class="text-center">No records found</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete this leave type?");
    }
    </script>
</body>
</html>
