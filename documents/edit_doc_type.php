<?php
// Include database connection
require_once('../connection/conn.php');
require_once('../sessions.php');

// Get the salary type ID from the URL
$document_id = isset($_GET['id']) ? $_GET['id'] : '';

if ($document_id) {
    // Create SQL query to fetch salary type data
    $query = "SELECT * FROM doc_types WHERE id = $document_id";
    $result = mysqli_query($conn, $query);

    // Check if a valid salary type is found
    if ($result && mysqli_num_rows($result) > 0) {
        $document = mysqli_fetch_assoc($result);
    } else {
        // If the salary type is not found, handle the error
        echo "Invalid document Type ID.";
        exit();
    }
} else {
    // If no ID is provided, show an error
    echo "Document Type ID is missing.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Document Type</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                Edit Document Type
                <a href="<?= site_url() ?>documents/documents.php" class="btn btn-light btn-sm">Back to List</a>
            </div>
            <div class="card-body">
                <form action="../form_handler.php" method="POST">
                    <!-- Hidden input to identify the form and the document type ID -->
                    <input type="hidden" name="form_type" value="edit_doc_type">
                    <input type="hidden" name="document_id" value="<?php echo $document['id']; ?>">

                    <div class="mb-3">
                        <label for="document_name" class="form-label">Document Type</label>
                        <!-- Populate the input with the current document type name -->
                        <input type="text" class="form-control" id="document_name" name="document_name" value="<?php echo $document['name']; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-success">Update</button>
            </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>