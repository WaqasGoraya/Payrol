<?php
// Database connection
require_once('./connection/conn.php');

// Fetch leave types
$leaveTypes = [];
$sql = "SELECT * FROM leave_types";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $leaveTypes[] = $row;
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $employeeName = $_POST['employee_name'];
    $supervisor = $_POST['supervisor'];
    $leaveType = $_POST['leave_type'];
    $reason = $_POST['reason'];
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];

    // Handle file upload
    $attachment = $_FILES['attachment']['name'];
    $attachmentTmp = $_FILES['attachment']['tmp_name'];
    $attachmentPath = 'leaves/uploads/' . basename($attachment);
    move_uploaded_file($attachmentTmp, $attachmentPath);

    // Email list (in this example, we are sending to the supervisor)
    $emailList = $supervisor . '@example.com';

    // Save form data to the database or send email, etc.
    // Example of saving to database:
    $stmt = $conn->prepare("INSERT INTO leave_requests (employee_name, supervisor, leave_type, reason, start_date, end_date, attachment, email_list) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('ssssssss', $employeeName, $supervisor, $leaveType, $reason, $startDate, $endDate, $attachment, $emailList);
    $stmt->execute();
    $stmt->close();

    echo "<div class='alert alert-success text-center'>Leave request submitted successfully!</div>";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .form-label {
            font-weight: bold;
            color: #333;
        }
        .form-control, .form-select {
            border-radius: 5px;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .form-header {
            text-align: center;
            margin-bottom: 20px;
            color: #007bff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="form-header">Leave Request Form</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="employee_name" class="form-label">Employee Name</label>
                <input type="text" class="form-control" id="employee_name" name="employee_name" required>
            </div>
            <div class="mb-3">
                <label for="supervisor" class="form-label">Supervisor</label>
                <input type="text" class="form-control" id="supervisor" name="supervisor" required>
            </div>
            <div class="mb-3">
                <label for="leave_type" class="form-label">Leave Type</label>
                <select class="form-select" id="leave_type" name="leave_type" required>
                    <option value="">Select Leave Type</option>
                <?php foreach ($leaveTypes as $type): ?>
                        <option value="<?= htmlspecialchars($type['name']) ?>"><?= htmlspecialchars($type['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="reason" class="form-label">Reason</label>
                <textarea class="form-control" id="reason" name="reason" rows="4" required></textarea>
            </div>
            <div class="mb-3">
                <label for="attachment" class="form-label">Attachment</label>
                <input class="form-control" type="file" id="attachment" name="attachment">
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="end_date" class="form-label">End Date</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100">Submit</button>
        </form>
    </div>
</body>
</html>
