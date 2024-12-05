<?php
// Database connection
require_once("../connection/conn.php");
require_once("../sessions.php");

$employee_id = $_POST['employee_id'];
$leave_counts = $_POST['leave_counts'];
$total_leaves = $_POST['total_leaves'];
$leaves_availed = $_POST['leaves_availed'];

// Insert or update leave data for each leave type
foreach ($leave_counts as $leave_type_id => $leave_count) {
    $leave_count = intval($leave_count); // Ensure it's an integer
    $insertLeaveQuery = "
        INSERT INTO leaves (employee_id, leave_type_id, leave_count, total_leaves, leaves_availed)
        VALUES ($employee_id, $leave_type_id, $leave_count, $total_leaves, $leaves_availed)
        ON DUPLICATE KEY UPDATE leave_count = $leave_count, total_leaves = $total_leaves, leaves_availed = $leaves_availed
    ";
    mysqli_query($conn, $insertLeaveQuery);
}
$_SESSION['message_type'] = 'success';
$_SESSION['message'] = 'Leaves saved successfully!';
header('Location:'.BASE_URL.'employees');

?>
