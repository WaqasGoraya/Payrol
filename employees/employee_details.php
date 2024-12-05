<?php
// Database connection
require_once('../connection/conn.php');
require_once('../sessions.php');

// Get employee id from query parameter
$employee_id = $_GET['id'];

// Fetch employee data
$sql = "SELECT e.*, d.name AS department_name, l.name AS location_name, 
               s.first_name AS supervisor_first_name, s.last_name AS supervisor_last_name
        FROM employee e
        LEFT JOIN departments d ON e.department_id = d.id
        LEFT JOIN locations l ON e.location_id = l.id
        LEFT JOIN employee s ON e.supervisor_id = s.id
        WHERE e.id = $employee_id";


$result = $conn->query($sql);
$employee = $result->fetch_assoc();


// Fetch employee documents
$doc_sql = "SELECT ed.*, dt.name AS doc_type
            FROM employee_documents ed
            LEFT JOIN doc_types dt ON ed.doc_type_id = dt.id
            WHERE ed.employee_id = $employee_id";
$doc_result = $conn->query($doc_sql);

// Fetch employee salary details
$salary_sql = "SELECT es.*, st.name AS salary_type 
                FROM employee_salaries es
                LEFT JOIN salary_types st ON es.salary_type_id = st.id
                WHERE es.employee_id = $employee_id";
$salary_result = $conn->query($salary_sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
          <!-- Heading and Dashboard Button -->
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Employees Details</h2>
            <a href="<?= site_url() ?>employees" class="btn btn-success">Go to Employees</a>
        </div>
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                Personal Information
            </div>
            <div class="card-body">
                <p><img src="<?php echo BASE_URL . $employee['emp_image'] ?>" alt="employeeImage" width="20%"></p>
                <p><strong>First Name:</strong> <?php echo $employee['first_name']; ?></p>
                <p><strong>Last Name:</strong> <?php echo $employee['last_name']; ?></p>
                <p><strong>Department:</strong> <?php echo $employee['department_name']; ?></p>
                <p><strong>Location:</strong> <?php echo $employee['location_name']; ?></p>
                <p><strong>Designation:</strong> <?php echo $employee['designation']; ?></p>
                <p><strong>Supervisor:</strong> <?php echo $employee['supervisor_first_name'] .' '. $employee['supervisor_last_name']; ?></p>
                <p><strong>Date of Joining:</strong> <?php echo $employee['joining_date']; ?></p>
                <p><strong>Date of Birth:</strong> <?php echo $employee['dob']; ?></p>
                <p><strong>Country:</strong> <?php echo $employee['country']; ?></p>
                <p><strong>City:</strong> <?php echo $employee['city']; ?></p>
                <p><strong>Address:</strong> <?php echo $employee['address1'] . ', ' . $employee['address2']; ?></p>
                <p><strong>Phone 1:</strong> <?php echo $employee['phone1']; ?></p>
                <p><strong>Phone 2:</strong> <?php echo $employee['phone2']; ?></p>
                <p><strong>Email 1:</strong> <?php echo $employee['email1']; ?></p>
                <p><strong>Email 2:</strong> <?php echo $employee['email2']; ?></p>
                <p><strong>Last Leave Date:</strong> <?php echo $employee['last_leave']; ?></p>
            </div>
        </div>

        <!-- Documents Section -->
        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                Documents
            </div>
            <div class="card-body">
                <div class="row">
                    <?php while ($doc = $doc_result->fetch_assoc()) { ?>
                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <p><strong>Document Type:</strong> <?php echo $doc['doc_type']; ?></p>
                                    <p><strong>Document Number:</strong> <?php echo $doc['doc_number']; ?></p>
                                    <p><strong>Issued Date:</strong> <?php echo $doc['doc_issue_date']; ?></p>
                                    <p><strong>Expiry Date:</strong> <?php echo $doc['doc_expiry_date']; ?></p>
                                    <p><strong>Alert Days:</strong> <?php echo $doc['doc_alert_days']; ?></p>
                                    <?php
                                    // Check if file is image
                                    $file_extension = pathinfo($doc['doc_file'], PATHINFO_EXTENSION);
                                    if (in_array(strtolower($file_extension), ['jpg', 'jpeg', 'png', 'gif'])) {
                                        echo '<img src="'. BASE_URL . $doc['doc_file'] . '" class="img-fluid" alt="Document">';
                                    } elseif (in_array(strtolower($file_extension), ['pdf'])) {
                                        echo '<a href="' . BASE_URL . $doc['doc_file'] . '" target="_blank"><img src="'. BASE_URL .'uploads/docs.png" class="img-fluid" width="200" height="200" caption="click to view"/></a>';
                                    } else {
                                        echo '<a href="' . BASE_URL . $doc['doc_file'] . '" target="_blank">Download File</a>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <!-- Salary Section -->
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                Salary Information
            </div>
            <div class="card-body">
                <div class="row">
                    <?php 
                    //$net_total = null; // Initialize net total variable
                    while ($sal = $salary_result->fetch_assoc()) {   
                    //  if ($net_total === null) {
                    //      $net_total = $sal['net_total']; // Store net_total only once from the first row
                    // }
                    ?>
                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <p><strong>Salary Type:</strong> <?php echo $sal['salary_type']; ?></p>
                                    <p><strong>Currency:</strong> <?php echo $sal['currency']; ?></p>
                                    <p><strong>Amount:</strong> <?php echo $sal['basic_salary']; ?></p>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                 <!-- Display Net Total Outside of Cards -->
                <!--<div class="net-total-section mt-4">-->
                <!--    <h5><strong>Net Total Salary: </strong> <?php echo $net_total; ?></h5>-->
                <!--</div>-->
            </div>
        </div>
    </div>
</body>

</html>