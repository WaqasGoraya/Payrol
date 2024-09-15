<?php
// Database connection
require_once("../connection/conn.php");
require_once("../sessions.php");

// Fetch employees data
$sql = "SELECT employees.id, employees.first_name, employees.last_name, departments.name as department_name, locations.name as location_name 
        FROM employees 
        LEFT JOIN departments ON employees.department_id = departments.id
        LEFT JOIN locations ON employees.location_id = locations.id";
$result = $conn->query($sql);
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
        <div class="card">
            <div class="card-header bg-primary text-white">
                Employees
                <a href="add_employee.php" class="btn btn-light btn-sm float-end">Add New</a>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
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
                                echo "<tr>
                                        <td>{$row['id']}</td>
                                        <td>{$row['first_name']}</td>
                                        <td>{$row['last_name']}</td>
                                        <td>{$row['department_name']}</td>
                                        <td>{$row['location_name']}</td>
                                        <td>
                                            <a href='edit_employee.php?id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
                                            <a href='delete_employee.php?id={$row['id']}' class='btn btn-danger btn-sm'>Delete</a>
                                        </td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6' class='text-center'>No records found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
