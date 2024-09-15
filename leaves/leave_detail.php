<?php
// Database connection
$host = 'localhost'; // Your database host
$dbname = 'payrol'; // Your database name
$user = 'root'; // Your database username
$pass = ''; // Your database password

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
require_once('../sessions.php');
// Fetch leave request details by ID
$leaveId = $_GET['id'];
$sql = "SELECT * FROM leave_requests WHERE id = ?";
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
                    <h5 class="card-title">Employee Name: <?= htmlspecialchars($leave['employee_name']) ?></h5>
                    <p class="card-text">Supervisor: <?= htmlspecialchars($leave['supervisor']) ?></p>
                    <p class="card-text">Leave Type: <?= htmlspecialchars($leave['leave_type']) ?></p>
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
