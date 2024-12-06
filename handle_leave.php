<?php
// Database connection
require('./connection/conn.php');
require('./send_email.php');

$message = ''; // Initialize message variable

if (isset($_GET['action']) && isset($_GET['leave_id']) && isset($_GET['emp_id']) && employeeExists($_GET['emp_id'])) {
    $action = $_GET['action'];
    $leaveId = intval($_GET['leave_id']);
    $empID = intval($_GET['emp_id']);

    // Fetch leave details and employee information
    $query = "SELECT * from leaves WHERE employee_id = $empID AND leave_type_id = $leaveId";
    $result = $conn->query($query);
    $leave = $result->fetch_assoc();

    $emailQuery = "SELECT * FROM employee WHERE id = $empID";
    $employee = $conn->query($emailQuery)->fetch_assoc();

    if ($leave) {
        $employeeId = $leave['employee_id'];
        $leaveTypeId = $leave['leave_type_id'];
        $leaveDays = $leave['leave_count'];

        if ($action === 'approve') {
            // Approve leave: Deduct leave days from the employee's leave balance
            $updateQuery = "UPDATE total_leaves 
                            SET remainig_leaves = remainig_leaves - $leaveDays, 
                                leaves_availed = leaves_availed + $leaveDays 
                            WHERE employee_id = $employeeId";
            $conn->query($updateQuery);

            // Update leave type
            $updateQuery = "UPDATE leaves 
                            SET leave_count = leave_count - $leaveDays 
                            WHERE employee_id = $employeeId AND leave_type_id = $leaveTypeId";
            $conn->query($updateQuery);

            // Send email notification
            $to = $employee['email1'];
            $subject = "Leave Application Approved";
            $message = "Dear " . $employee['first_name'] . ' ' . $employee['last_name'] . ",\n\nYour leave application has been Approved.\n\nBest regards,\nPetrofast";
            email_notification($to, $subject, $message);

            // Set the success message to be displayed
            $message = "<div class='alert alert-success'>
                            <strong>Success!</strong> Leave approved. Balance updated and email notification sent to employee.
                        </div>";
        } elseif ($action === 'reject') {
            // Reject leave: Notify employee
            if ($employee) {
                $to = $employee['email1'];
                $subject = "Leave Application Rejected";
                $message = "Dear " . $employee['first_name'] . ' ' . $employee['first_name'] . ",\n\nYour leave application has been rejected.\n\nBest regards,\nYour Company";
                email_notification($to, $subject, $message);

                // Set the rejection message to be displayed
                $message = "<div class='alert alert-danger'>
                            <strong>Rejected!</strong> Leave rejected, and email notification sent to employee.
                        </div>";
            }
        }
    } else {
        // Set error message for invalid leave ID
        $message = "<div class='alert alert-warning'>
                    <strong>Warning!</strong> Invalid leave ID.
                    </div>";
    }
} else {
    // Set error message for invalid request
    $message = "<div class='alert alert-danger'>
                <strong>Error!</strong> Invalid request.
                </div>";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Application Status</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        html, body {
            height: 100%;  /* Ensure the body takes full height */
            margin: 0;  /* Remove default margin */
        }
        .wrapper {
            display: flex;
            flex-direction: column;
            height: 100%;  /* Ensure the wrapper takes full height */
        }
        .content {
            flex: 1;  /* Content section will occupy remaining space */
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;  /* Ensure text is centered */
        }
        .alert {
            font-size: 1.2em;  /* Larger text for better readability */
            padding: 15px;  /* Add padding for a more spacious look */
            border-radius: 8px;  /* Rounded corners for the alert box */
        }
    </style>
</head>
<body>

    <div class="wrapper">
        <!-- Header Section -->
        <header class="bg-primary text-white py-3">
            <div class="container text-center">
                <h1>Leave Management</h1>
            </div>
        </header>

        <!-- Main Content Section -->
        <div class="content container mt-5">
            <div class="text-center mt-4">
                <!-- This will ensure that the PHP message is part of the body and loaded properly -->
                <?php 
                    if (isset($message)) {
                        echo  $message; 
                    }
                ?>
            </div>
        </div>

        <!-- Footer Section -->
        <footer class="bg-dark text-white py-4 mt-5">
            <div class="container text-center">
                <p>&copy; 2024 Petrofast | All Rights Reserved</p>
            </div>
        </footer>
    </div>

    <!-- Bootstrap JS (for dismissing the alert) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>