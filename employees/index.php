<?php
// Database connection
require_once("../connection/conn.php");
require_once("../sessions.php");
  // Key for encryption (must be securely stored)
  define('SECRET_KEY', 'ifhi4984rb4uybfuiwyfro34ybcsdcuyhb4uir7y4389rfbc89ryhfn4c948'); // Replace with a strong secret key
  define('SECRET_IV', 'sjo9ji3buybu&%F5##$vgujukhdicscbjckuekfjbkufhwebcjwuckjbkjb.ek'); // Replace with a strong secret IV
  
// Fetch employees data
$sql = "SELECT employee.id,employee.employee_code,employee.encrypted_password, employee.first_name, employee.last_name,employee.emp_status, departments.name as department_name, locations.name as location_name 
        FROM employee
        LEFT JOIN departments ON employee.department_id = departments.id
        LEFT JOIN locations ON employee.location_id = locations.id";
$result = $conn->query($sql);

function decryptPassword($encrypted_password) {
    $encryption_key = base64_decode(SECRET_KEY);
    $iv = substr(hash('sha256', SECRET_IV), 0, 16);
    return openssl_decrypt($encrypted_password, 'AES-256-CBC', $encryption_key, 0, $iv);
}
// Delete Employee
// Check if delete_id is set in the URL
if (isset($_GET['delete_id'])) {
    $employee_id = $_GET['delete_id'];

    // Delete documents
    $doc_sql = "SELECT * FROM employee_documents WHERE employee_id = $employee_id";
    $doc_result = $conn->query($doc_sql);

    // Loop through each document record
    while ($doc = $doc_result->fetch_assoc()) {
        // Construct the file path (assuming your files are stored in 'uploads/' folder)
        $filePath = __DIR__ . '/../' . $doc['doc_file'];
        // Check if the file exists in the 'uploads' directory
        if (file_exists($filePath)) {
            // Delete the file from the server
            unlink($filePath);
        } 
    }
    // Delete documents from the database
    $delete_doc_sql = "DELETE FROM employee_documents WHERE employee_id = $employee_id";
    $conn->query($delete_doc_sql);

    // Delete salaries
    $employee_salary = "DELETE FROM employee_salaries WHERE employee_id = $employee_id";
    $conn->query($employee_salary);

    // SQL query to delete the employee by ID
    $leaves_query = "DELETE FROM leaves WHERE employee_id = $employee_id";
    $conn->query($leaves_query);

    // SQL query to delete the employee by ID
    $query = "DELETE FROM employee WHERE id = $employee_id";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Redirect to the same page to refresh the list after deletion
        $_SESSION['message_type'] = 'success';
        $_SESSION['message'] = 'Employee Deleted Successfully!';
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        $_SESSION['message_type'] = 'error';
        $_SESSION['message'] = 'Something went wrong!';
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employees</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <!-- Heading and Dashboard Button -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Employees Managment</h2>
            <a href="<?= site_url() ?>dashboard.php" class="btn btn-primary">Go to Dashboard</a>
        </div>
        <!-- Alert Message -->
        <?php if (isset($_SESSION['message_type']) && isset($_SESSION['message']) && $_SESSION['message_type'] === 'success'): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $_SESSION['message']; ?>
            </div>
        <?php endif; ?>
        <div class="card">
            <div class="card-header bg-primary text-white">
                Employees
                <a href="add_employee.php" class="btn btn-light btn-sm float-end">Add New</a>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Code</th>
                            <th>Password</th>
                            <th>Status</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Department</th>
                            <th>Location</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $originalPassword = decryptPassword($row['encrypted_password']);
                                $status = 'Active';
                                if($row['emp_status'] == 0){
                                    $status = 'Inactive';
                                }
                                echo "<tr>
                                        <td>{$row['employee_code']}</td>
                                        <td>{$originalPassword}</td>
                                        <td>{$status}</td>
                                        <td>{$row['first_name']}</td>
                                        <td>{$row['last_name']}</td>
                                        <td>{$row['department_name']}</td>
                                        <td>{$row['location_name']}</td>
                                        <td>
                                        <a href='manage_leave.php?employee_id={$row['id']}' class='btn btn-primary btn-sm'>Manage Leaves</a>

                                            <a href='employee_details.php?id={$row['id']}' class='btn btn-success btn-sm'>Details</a>
                                            <a href='edit_employee.php?id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
                                            <a href='?delete_id={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirmDelete();'>Delete</a>
                                        </td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='8' class='text-center'>No records found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this Employee?");
        }
    </script>
</body>

</html>

<?php
$conn->close();
?>