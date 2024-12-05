<?php

require_once('../sessions.php');
require_once('../db_conn.php');
// Fetch leave request details by ID
$leaveId = $_GET['id'];

$sql = "
    SELECT 
        t1.*, 
        CONCAT(t2.first_name, ' ', t2.last_name) AS emp_name,
        t3.name AS leave_type_name
    FROM 
        leave_requests t1
    LEFT JOIN 
        employee t2 ON t2.id = t1.employee_id
    LEFT JOIN 
        leave_types t3 ON t3.id = t1.leave_type
    WHERE 
        t1.id = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $leaveId);
$stmt->execute();
$result = $stmt->get_result();
$leave = $result->fetch_assoc();
$stmt->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Detail</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Leave Request Details</h2>
        <?php if ($leave): ?>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Employee Name: <?= htmlspecialchars($leave['emp_name']) ?></h5>
                    <p class="card-text">Supervisor: <?= htmlspecialchars($leave['supervisor']) ?></p>
                    <p class="card-text">Leave Type: <?= htmlspecialchars($leave['leave_type_name']) ?></p>
                    <p class="card-text">Reason: <?= htmlspecialchars($leave['reason']) ?></p>
                    <p class="card-text">Start Date: <?= htmlspecialchars($leave['start_date']) ?></p>
                    <p class="card-text">End Date: <?= htmlspecialchars($leave['end_date']) ?></p>
                    <p class="card-text">Attachment: 
                        <?php if ($leave['attachment']): ?>
                            <a href="<?= 'uploads/' . htmlspecialchars($leave['attachment']) ?>" target="_blank">View Attachment</a>
                        <?php else: ?>
                            No attachment provided.
                        <?php endif; ?>
                    </p>
                    <a href="leave_request.php" class="btn btn-secondary">Back to List</a>
                </div>
            </div>
        <?php else: ?>
            <p class="text-center">Leave request not found.</p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
$conn->close();
?>
