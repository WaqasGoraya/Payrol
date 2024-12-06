<?php
// Database connection
require_once("../connection/conn.php");
require_once("../sessions.php");

$employee_id = intval($_POST['employee_id']);
$leave_counts = $_POST['leave_counts']; // Should be an associative array
$total_leaves = intval($_POST['total_leaves']);
$leaves_availed = intval($_POST['leaves_availed']);

// Insert or update leave data for each leave type
foreach ($leave_counts as $leave_type_id => $leave_count) {
    $leave_type_id = intval($leave_type_id);
    $leave_count = intval($leave_count); // Ensure it's an integer

    $insertLeaveQuery = "
        INSERT INTO leaves (employee_id, leave_type_id, leave_count)
        VALUES ($employee_id, $leave_type_id, $leave_count)
        ON DUPLICATE KEY UPDATE 
            leave_count = VALUES(leave_count)";

    // Execute the query
    if (!mysqli_query($conn, $insertLeaveQuery)) {
        echo "Error: " . mysqli_error($conn);
        exit;
    }
}
$total_leaves_query = "
    INSERT INTO total_leaves (employee_id, remainig_leaves)
    VALUES ($employee_id, $total_leaves)
    ON DUPLICATE KEY UPDATE remainig_leaves = $total_leaves
";// Execute the query
if (!mysqli_query($conn, $total_leaves_query)) {
    echo "Error: " . mysqli_error($conn);
    exit;
}
$_SESSION['message_type'] = 'success';
$_SESSION['message'] = 'Leave saved successfully!';
header('Location:' . BASE_URL . 'employees');
