<?php
// Database connection
require_once('../connection/conn.php');

// Fetch all leave requests
$sql = "SELECT * FROM leave_requests";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Leave Requests</h2>
        <a href="<?= site_url()?>leaves/leaves.php" class="btn btn-primary mb-3">Back to Dashboard</a>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Employee Name</th>
                    <th>Supervisor</th>
                    <th>Leave Type</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['id']) ?></td>
                            <td><?= htmlspecialchars($row['employee_name']) ?></td>
                            <td><?= htmlspecialchars($row['supervisor']) ?></td>
                            <td><?= htmlspecialchars($row['leave_type']) ?></td>
                            <td><?= htmlspecialchars($row['start_date']) ?></td>
                            <td><?= htmlspecialchars($row['end_date']) ?></td>
                            <td>
                                <a href="leave_detail.php?id=<?= $row['id'] ?>" class="btn btn-primary">
                                    <i class="bi bi-eye"></i> View
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">No leave requests found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
$conn->close();
?>
