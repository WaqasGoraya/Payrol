<?php
// Database connection
// require_once('./sessions.php'); 
require('./connection/conn.php');
require('./send_email.php');

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
            $updateQuery = "UPDATE leaves 
            SET leaves_availed = leaves_availed + $leaveDays 
            WHERE employee_id = $employeeId 
            ORDER BY leaves_availed ASC 
            LIMIT 1";

            // $updateQuery = "UPDATE leaves 
            //                 SET leave_count = leave_count - $leaveDays, leaves_availed = leaves_availed - $leaveDays
            //                 WHERE employee_id = $employeeId AND leave_type_id = $leaveTypeId";
            $conn->query($updateQuery);

            $to = $employee['email1'];
            $subject = "Leave Application Approved";
            $message = "Dear " . $employee['first_name'] . ' ' . $employee['last_name'] . ",\n\nYour leave application has been Approved.\n\nBest regards,\nPetrofast";

            email_notification($to, $subject, $message);
            echo "Leave approved balance updated and email notification sent.";
        } elseif ($action === 'reject') {
            // Reject leave: Notify employee

            if ($employee) {
                $to = $employee['email1'];
                $subject = "Leave Application Rejected";
                $message = "Dear " . $employee['first_name'] . ' ' . $employee['first_name'] . ",\n\nYour leave application has been rejected.\n\nBest regards,\nYour Company";

                email_notification($to, $subject, $message);
                echo "Leave rejected, and email notification sent.";
            }
        }
    } else {
        echo "Invalid leave ID.";
    }
} else {
    echo "Invalid request.";
}

$conn->close();
