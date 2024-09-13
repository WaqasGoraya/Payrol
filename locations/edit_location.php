<?php
// Include database connection
require_once('../connection/conn.php');
require_once('../sessions.php');

// Get the salary type ID from the URL
$location_id = isset($_GET['id']) ? $_GET['id'] : '';

if ($location_id) {
    // Create SQL query to fetch salary type data
    $query = "SELECT * FROM locations WHERE id = $location_id";
    $result = mysqli_query($conn, $query);

    // Check if a valid salary type is found
    if ($result && mysqli_num_rows($result) > 0) {
        $location = mysqli_fetch_assoc($result);
    } else {
        // If the salary type is not found, handle the error
        echo "Invalid location ID.";
        exit();
    }
} else {
    // If no ID is provided, show an error
    echo "Location is missing.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Location</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                Edit Location
                <a href="<?= site_url() ?>locations/location.php" class="btn btn-light btn-sm">Back to List</a>
            </div>
            <div class="card-body">
                <form action="../form_handler.php" method="POST">
                    <!-- Hidden input to identify the form and the Location ID -->
                    <input type="hidden" name="form_type" value="edit_location">
                    <input type="hidden" name="location_id" value="<?php echo $location['id']; ?>">

                    <div class="mb-3">
                        <label for="location_name" class="form-label">Location Name</label>
                        <!-- Populate the input with the current Location name -->
                        <input type="text" class="form-control" id="location_name" name="location_name" value="<?php echo $location['name']; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-success">Update</button>
            </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>