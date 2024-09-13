<?php
// Database connection
require_once('../connection/conn.php');
require_once('../sessions.php');

// Fetch salary types data
$sql = "SELECT id, name FROM salary_types";
$result = $conn->query($sql);

// Check if delete_id is set in the URL
if (isset($_GET['delete_id'])) {
    $salary_type_id = $_GET['delete_id'];

    // SQL query to delete the salary type by ID
    $query = "DELETE FROM salary_types WHERE id = $salary_type_id";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Redirect to the same page to refresh the list after deletion
        $_SESSION['message_type'] = 'success';
        $_SESSION['message'] = 'Salary Type Deleted Successfully!';
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "Error deleting salary type: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salary Types</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        
        <!-- Heading and Dashboard Button -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Salary Types</h2>
            <a href="<?= site_url()?>dashboard.php" class="btn btn-primary">Go to Dashboard</a>
        </div>

        <!-- Alert Message -->
        <?php if(isset($_SESSION['message_type']) && isset($_SESSION['message']) && $_SESSION['message_type'] === 'success'): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $_SESSION['message']; ?>
            </div>
        <?php endif;?>

        <div class="card">
            <div class="card-header bg-danger text-white">
                Salary Types
                <a href="add_salary_type.php" class="btn btn-light btn-sm float-end">Add New</a>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Salary Type</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td>{$row['id']}</td>
                                        <td>{$row['name']}</td>
                                        <td>
                                            <a href='edit_salary_type.php?id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
                                            <a href='?delete_id={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirmDelete();'>Delete</a>
                                        </td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3' class='text-center'>No records found</td></tr>";
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
        return confirm("Are you sure you want to delete this salary type?");
    }
    </script>
</body>
</html>

