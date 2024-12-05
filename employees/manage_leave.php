<?php
// Database connection
require_once("../connection/conn.php");
require_once("../sessions.php");
if($_GET['employee_id'] && employeeExists($_GET['employee_id'])){
// Get employee ID from URL or request
$employee_id = $_GET['employee_id'];

// Fetch leave types from the database
$leaveTypesQuery = "SELECT * FROM leave_types";
$leaveTypesResult = mysqli_query($conn, $leaveTypesQuery);

// Fetch existing leave data for the employee
$existingLeavesQuery = "SELECT * FROM leaves WHERE employee_id = $employee_id";
$existingLeavesResult = mysqli_query($conn, $existingLeavesQuery);

// fetch user data
$employeeQuery = "SELECT * FROM employee WHERE id = $employee_id";
$employeeResult = mysqli_query($conn, $employeeQuery);
$userData = mysqli_fetch_assoc($employeeResult);

// fetch leaves availed
$remaining_leaves_query = "SELECT leaves_availed FROM leaves WHERE employee_id = $employee_id LIMIT 1";
$remaining_leaves = $conn->query($remaining_leaves_query)->fetch_assoc();

// Initialize an array to store existing leave counts
$existingLeaves = [];
while ($row = mysqli_fetch_assoc($existingLeavesResult)) {
    $existingLeaves[$row['leave_type_id']] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Management</title>
     <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        // JavaScript function to calculate total leaves based on input fields
        function calculateTotalLeaves() {
            let total = 0;
            let leaveInputs = document.querySelectorAll('.leave-input');
            leaveInputs.forEach(input => {
                total += parseInt(input.value) || 0;
            });
            document.getElementById('total_leaves').value = total;
        }
    </script>
</head>
<body>
    <div class="container mt-5">
    <h2 class="text-center">Manage Leaves for <?php echo $userData['first_name'] .' '. $userData['last_name']; ?></h2>

        <form action="save_leave.php" method="POST" class="p-4 border rounded shadow-sm">
            <input type="hidden" name="employee_id" value="<?php echo htmlspecialchars($employee_id); ?>">

            <!-- Dynamic Leave Type Inputs -->
            <?php while ($leaveType = mysqli_fetch_assoc($leaveTypesResult)): ?>
                <?php
                    // Retrieve the leave count if it exists, otherwise set it to 0
                    $leave_count = isset($existingLeaves[$leaveType['id']]) ? $existingLeaves[$leaveType['id']]['leave_count'] : 0;
                ?>
                <div class="mb-3">
                    <label for="leave_type_<?php echo $leaveType['id']; ?>" class="form-label">
                        <?php echo htmlspecialchars($leaveType['name']); ?> Leave
                    </label>
                    <input type="number" name="leave_counts[<?php echo $leaveType['id']; ?>]" 
                           id="leave_type_<?php echo $leaveType['id']; ?>" 
                           class="form-control leave-input" value="<?php echo $leave_count; ?>" min="0"
                           onchange="calculateTotalLeaves()" required>
                </div>
            <?php endwhile; ?>

            <!-- Total Leaves and Leaves Availed -->
            <div class="mb-3">
                <label for="total_leaves" class="form-label">Total Leaves</label>
                <input type="number" id="total_leaves" name="total_leaves" class="form-control" 
                       value="<?php echo array_sum(array_column($existingLeaves, 'leave_count')); ?>" readonly>
            </div>

            <div class="mb-3">
                <label for="leaves_availed" class="form-label">Leaves Availed</label>
                <input type="number" id="leaves_availed" name="leaves_availed" class="form-control" 
                       value="<?php echo $remaining_leaves['leaves_availed']; ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="remaning_leaves" class="form-label">Remaning Leaves</label>
                <input type="number" id="remaning_leaves" name="remaning_leaves" class="form-control" 
                       value="<?php echo array_sum(array_column($existingLeaves, 'leave_count')) - $remaining_leaves['leaves_availed']; ?>" readonly>
            </div>

            <!-- Submit Button -->
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Save Leaves</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
</body>
</html>
<?php } else { header('Location:'.BASE_URL.'employees'); }?>
