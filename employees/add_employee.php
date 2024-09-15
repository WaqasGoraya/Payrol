<?php 
require_once('../sessions.php');
require('../connection/conn.php'); 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Employee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Add New Employee</h1>
            <a href="employees.php" class="btn btn-success">Go Back to List</a>
        </div>
        <form action="../form_handler.php" method="post">
            <!-- Hidden Field to Identify the Form Type -->
            <input type="hidden" name="form_type" value="employee">

            <!-- Personal Details Section -->
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4>Personal Details</h4>
                </div>
                <div class="card-body row">
                    <div class="col-md-6">
                        <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="first_name" name="first_name" required>
                    </div>

                    <div class="col-md-6">
                        <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="last_name" name="last_name" required>
                    </div>

                    <div class="col-md-6">
                        <label for="department_id" class="form-label">Department <span class="text-danger">*</span></label>
                        <select id="department_id" name="department_id" class="form-select" required>
                            <option value="">Select Department</option>
                            <?php
                            $sql = $conn->query("SELECT id, name FROM departments");
                            while ($row = $sql->fetch_assoc()) {
                                echo "<option value=\"{$row['id']}\">{$row['name']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="location_id" class="form-label">Location <span class="text-danger">*</span></label>
                        <select id="location_id" name="location_id" class="form-select" required>
                            <option value="">Select Location</option>
                            <?php
                            $sql = $conn->query("SELECT id, name FROM locations");
                            while ($row = $sql->fetch_assoc()) {
                                echo "<option value=\"{$row['id']}\">{$row['name']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="company" class="form-label">Company</label>
                        <input type="text" class="form-control" id="company" name="company">
                    </div>
                    <div class="col-md-6">
                        <label for="designation" class="form-label">Designation</label>
                        <input type="text" class="form-control" id="designation" name="designation">
                    </div>

                    <div class="col-md-6">
                        <label for="date_of_join" class="form-label">Date of Join</label>
                        <input type="date" class="form-control" id="date_of_join" name="date_of_join">
                    </div>

                    <div class="col-md-6">
                        <label for="date_of_birth" class="form-label">Date of Birth</label>
                        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth">
                    </div>

                    <div class="col-md-6">
                        <label for="country" class="form-label">Country</label>
                        <input type="text" class="form-control" id="country" name="country">
                    </div>

                    <div class="col-md-6">
                        <label for="city" class="form-label">City</label>
                        <input type="text" class="form-control" id="city" name="city">
                    </div>

                    <div class="col-md-6">
                        <label for="address1" class="form-label">Address 1</label>
                        <input type="text" class="form-control" id="address1" name="address1">
                    </div>

                    <div class="col-md-6">
                        <label for="address2" class="form-label">Address 2</label>
                        <input type="text" class="form-control" id="address2" name="address2">
                    </div>

                    <div class="col-md-6">
                        <label for="phone1" class="form-label">Offical Phone</label>
                        <input type="text" class="form-control" id="phone1" name="phone1">
                    </div>

                    <div class="col-md-6">
                        <label for="phone2" class="form-label">Personal Phone</label>
                        <input type="text" class="form-control" id="phone2" name="phone2">
                    </div>

                    <div class="col-md-6">
                        <label for="email1" class="form-label">Official Email</label>
                        <input type="email" class="form-control" id="email1" name="email1">
                    </div>

                    <div class="col-md-6">
                        <label for="email2" class="form-label">Personal Email</label>
                        <input type="email" class="form-control" id="email2" name="email2">
                    </div>
                </div>
            </div>

            <!-- Document Details Section -->
            <div class="card mt-4">
                <div class="card-header bg-primary text-white">
                    <h4>Document Details</h4>
                </div>
                <div class="card-body row">
                    <div class="col-md-6">
                        <label for="doc_type_id" class="form-label">Document Type <span class="text-danger">*</span></label>
                        <select id="doc_type_id" name="doc_type_id" class="form-select" required>
                            <option value="">Select Document Type</option>
                            <?php
                            $sql = $conn->query("SELECT id, name FROM doc_types");
                            while ($row = $sql->fetch_assoc()) {
                                echo "<option value=\"{$row['id']}\">{$row['name']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="doc_number" class="form-label">Document Number</label>
                        <input type="text" class="form-control" id="doc_number" name="doc_number">
                    </div>

                    <div class="col-md-6">
                        <label for="doc_issue_date" class="form-label">Document Issue Date</label>
                        <input type="date" class="form-control" id="doc_issue_date" name="doc_issue_date">
                    </div>

                    <div class="col-md-6">
                        <label for="doc_expiry_date" class="form-label">Document Expiry Date</label>
                        <input type="date" class="form-control" id="doc_expiry_date" name="doc_expiry_date">
                    </div>

                    <div class="col-md-6">
                        <label for="doc_attachment" class="form-label">Document Attachment</label>
                        <input type="file" class="form-control" id="doc_attachment" name="doc_attachment">
                    </div>
                </div>
            </div>

            <!-- Salary Details Section -->
            <div class="card mt-4">
                <div class="card-header bg-primary text-white">
                    <h4>Salary Details</h4>
                </div>
                <div class="card-body row">
                    <div class="col-md-6">
                        <label for="salary_type_id" class="form-label">Salary Type <span class="text-danger">*</span></label>
                        <select id="salary_type_id" name="salary_type_id" class="form-select" required>
                            <option value="">Select Salary Type</option>
                            <?php
                            $sql = $conn->query("SELECT id, name FROM salary_types");
                            while ($row = $sql->fetch_assoc()) {
                                echo "<option value=\"{$row['id']}\">{$row['name']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="currency" class="form-label">Currency</label>
                        <input type="text" class="form-control" id="currency" name="currency">
                    </div>

                    <div class="col-md-3">
                        <label for="basic_salary" class="form-label">Basic Salary</label>
                        <input type="number" class="form-control" id="basic_salary" name="basic_salary" step="0.01">
                    </div>

                    <div class="col-md-6">
                        <label for="net_total" class="form-label">Net Total</label>
                        <input type="number" class="form-control" id="net_total" name="net_total" step="0.01">
                    </div>
                </div>
            </div>
            <div class="row my-5">
                <!-- Submit Button -->
                <div class="col-6">
                    <button type="submit" class="btn btn-success w-100">Submit</button>
                </div>
                <div class="col-6">
                    <button type="reset" class="btn btn-danger w-100">Reset</button>
                </div>
            </div>
        </form>
    </div>
</body>

</html>