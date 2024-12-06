<?php
session_start();
// Database connection
require_once('./connection/conn.php');
require_once('send_email.php');

// Fetch leave types
$leaveTypes = [];
$sql = "SELECT * FROM leave_types";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $leaveTypes[] = $row;
    }
}
// Fetch employees
$employees = [];
$employee_sql = "SELECT * FROM employee";
$employee_result = $conn->query($employee_sql);

if ($employee_result->num_rows > 0) {
    while ($row = $employee_result->fetch_assoc()) {
        $employees[] = $row;
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $employeeID = $_POST['employee_id'];
    $supervisor = $_POST['supervisor'];
    $leaveType = $_POST['leave_type'];
    $reason = $_POST['reason'];
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];
    $supervisor_email = $_POST['supervisor_email'];
    $total_days = $_POST['total_days'];

    // Handle file upload
    $attachment = $_FILES['attachment']['name'];
    $attachmentTmp = $_FILES['attachment']['tmp_name'];
    $attachmentPath = 'leaves/uploads/' . basename($attachment);
    move_uploaded_file($attachmentTmp, $attachmentPath);
    
    if($supervisor == '' || $supervisor_email == ''){
        $_SESSION['message_type'] = 'danger';
        $_SESSION['message'] = 'You cannt apply leave because supervisor is not assigned!';
        header("Location: {$_SERVER['HTTP_REFERER']}"); // Redirects back to the previous page
        exit;
    }
    // get remaining leaves 
    $leaveQuery = "SELECT remainig_leaves FROM total_leaves WHERE employee_id = $employeeID";
    $leaves = $conn->query($leaveQuery)->fetch_assoc();
    $remainingLeaves = $leaves['remainig_leaves'];


    if ($remainingLeaves <= 0) {
        $_SESSION['message_type'] = 'danger';
        $_SESSION['message'] = 'Your leave balance is 0!';
        header("Location: {$_SERVER['HTTP_REFERER']}"); // Redirects back to the previous page
        exit;
    };

    // get employee name
    $emailQuery = "SELECT * FROM employee WHERE id = $employeeID";
    $employee = $conn->query($emailQuery)->fetch_assoc();

    $employeeName = $employee['first_name'] . ' ' . $employee['last_name'];


    sendLeaveNotification($supervisor_email, $supervisor, $employeeID, $employeeName, $total_days, $leaveType, $startDate, $endDate);

    // Save form data to the database and send email, etc.
    $stmt = $conn->prepare("INSERT INTO leave_requests (employee_id, supervisor, leave_type, reason, start_date, end_date, attachment,total_days) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('ssssssss', $employeeID, $supervisor, $leaveType, $reason, $startDate, $endDate, $attachment, $total_days);
    $stmt->execute();
    $stmt->close();
    $_SESSION['message_type'] = 'success';
    $_SESSION['message'] = 'Leave request submitted successfully!';
    header("Location: {$_SERVER['HTTP_REFERER']}"); // Redirects back to the previous page
    exit;
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

        .form-control,
        .form-select {
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
        <?php
        

        if (isset($_SESSION['message'])) {
            $messageType = $_SESSION['message_type'] ?? 'info';
            echo "<div class='alert alert-$messageType text-center'>{$_SESSION['message']}</div>";
            unset($_SESSION['message'], $_SESSION['message_type']); // Clear the message after displaying it
        }
        ?>

        <h2 class="form-header">Leave Request Form</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="supervisor_email" id="supervisor_email">
            <input type="hidden" name="total_days" id="total_days">
            <div class="mb-3">
                <label for="employee_name" class="form-label">Employee Name</label>
                <select class="form-select" id="employee_id" name="employee_id" required>
                    <option value="">Select Employee Name</option>
                    <?php foreach ($employees as $employee): ?>
                        <option value="<?= htmlspecialchars($employee['id']) ?>" data-supervisor="<?= htmlspecialchars($employee['supervisor_id']) ?>"><?= htmlspecialchars($employee['first_name'] . ' ' . $employee['last_name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="supervisor" class="form-label">Supervisor</label>
                <input type="text" class="form-control" id="supervisor" name="supervisor" readonly>
            </div>
            <div class="mb-3">
                <label for="leave_type" class="form-label">Leave Type</label>
                <select class="form-select" id="leave_type" name="leave_type" required>
                    <option value="">Select Leave Type</option>
                    <?php foreach ($leaveTypes as $type): ?>
                        <option value="<?= htmlspecialchars($type['id']) ?>"><?= htmlspecialchars($type['name']) ?></option>
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
                    <input type="date" class="form-control" id="start_date" name="start_date" required min="<?php echo date("Y-m-d"); ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="end_date" class="form-label">End Date</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" required min="<?php echo date("Y-m-d"); ?>">
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100">Submit</button>
        </form>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $('#employee_id').on('change', function() {
            let empId = $('option:selected').attr('data-supervisor')

            // AJAX request to call the PHP script
            $.ajax({
                url: 'connection/conn.php',
                type: 'GET',
                data: {
                    empId: empId
                },
                success: function(response) {
                    let data = JSON.parse(response);
                    $("#supervisor").val(data.name)
                    $("#supervisor_email").val(data.email)
                },
                error: function() {
                    console.log("Error retrieving supervisor name.");
                }
            });
        });
        $('#end_date').on('change', function() {
            const startDate = new Date(document.getElementById('start_date').value);
            if (startDate == 'Invalid Date' || startDate == undefined) {
                alert('Please Select Start Date First!')
                $('#end_date').val(null);
            } else {
                const endDate = new Date(this.value);

                // Calculate the difference in days
                const diffInTime = endDate - startDate;
                const diffInDays = diffInTime / (1000 * 60 * 60 * 24) + 1;

                // Set the calculated days in the leave_days field
                if (diffInDays > 0) {
                    $('#total_days').val(diffInDays);
                } else {
                    $('#total_days').val(0);
                }
            }
        });
    </script>
</body>

</html>