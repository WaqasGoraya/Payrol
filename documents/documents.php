<?php
// Database connection
require_once('../connection/conn.php');
require_once('../sessions.php');

// Fetch document types data
$sql = "SELECT id, name FROM doc_types";
$result = $conn->query($sql);

// Check if delete_id is set in the URL
if (isset($_GET['delete_id'])) {
    $document_id = $_GET['delete_id'];

    // SQL query to delete the document by ID
    $query = "DELETE FROM doc_types WHERE id = $document_id";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Redirect to the same page to refresh the list after deletion
        $_SESSION['message_type'] = 'success';
        $_SESSION['message'] = 'Document Type Deleted Successfully!';
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
    <title>Document Types</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <!-- Heading and Dashboard Button -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Documents Type Managment</h2>
            <a href="<?= site_url() ?>dashboard.php" class="btn btn-primary">Go to Dashboard</a>
        </div>
        <!-- Alert Message -->
        <?php if (isset($_SESSION['message_type']) && isset($_SESSION['message']) && $_SESSION['message_type'] === 'success'): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $_SESSION['message']; ?>
            </div>
        <?php endif; ?>
        <div class="card">
            <div class="card-header bg-warning text-white">
                Document Types
                <a href="add_doc_type.php" class="btn btn-light btn-sm float-end">Add New</a>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Document Type</th>
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
                                            <a href='edit_doc_type.php?id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
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
            return confirm("Are you sure you want to delete this document type?");
        }
    </script>
</body>

</html>