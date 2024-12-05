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
            <a href="/employee/employees" class="btn btn-success">Go Back to List</a>
        </div>
        <form action="../form_handler.php" method="POST" enctype="multipart/form-data">
            <!-- Hidden Field to Identify the Form Type -->
            <input type="hidden" name="form_type" value="employee">

            <!-- Personal Details Section -->
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4>Personal Details</h4>
                </div>
                <div class="card-body row">
                    <div class="col-md-6">
                        <label for="emp_image" class="form-label">Employee Photo <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="emp_image" name="emp_image" required>
                    </div>
                    <div class="col-md-6">
                    <label for="last_leave" class="form-label">Last Leave Date<span class="text-danger">*</span></label>
                    <input type="date" class="form-control" name="last_leave">
                    </div>
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
                        <input type="text" class="form-control" id="company" name="company" required>
                    </div>
                    <div class="col-md-6">
                        <label for="supervisor" class="form-label">Supervisor</label>
                        <select name="supervisor_id" id="supervisor" class="form-select">
                            <option value="">Select Supervisor</option>
                            <?php
                            $sql = $conn->query("SELECT id, first_name,last_name from employee");
                            while ($row = $sql->fetch_assoc()) {
                                echo "<option value=\"{$row['id']}\">{$row['first_name']} {$row['last_name']}</option>";
                            }
                            ?>
                        </select>
                        <!-- <input type="text" class="form-control" id="supervisor" name="supervisor_id"> -->
                    </div>
                    <div class="col-md-6">
                        <label for="designation" class="form-label">Designation</label>
                        <input type="text" class="form-control" id="designation" name="designation" required>
                    </div>

                    <div class="col-md-6">
                        <label for="date_of_join" class="form-label">Date of Join</label>
                        <input type="date" class="form-control" id="date_of_join" name="date_of_join" required>
                    </div>

                    <div class="col-md-6">
                        <label for="date_of_birth" class="form-label">Date of Birth</label>
                        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" required>
                    </div>

                    <div class="col-md-6">
                        <label for="country" class="form-label">Country</label>
                        <input type="text" class="form-control" id="country" name="country" required>
                    </div>

                    <div class="col-md-6">
                        <label for="city" class="form-label">City</label>
                        <input type="text" class="form-control" id="city" name="city" required>
                    </div>

                    <div class="col-md-6">
                        <label for="address1" class="form-label">Official Address</label>
                        <input type="text" class="form-control" id="address1" name="address1" required>
                    </div>

                    <div class="col-md-6">
                        <label for="address2" class="form-label">Personal Address</label>
                        <input type="text" class="form-control" id="address2" name="address2" required>
                    </div>

                    <div class="col-md-6">
                        <label for="phone1" class="form-label">Offical Phone</label>
                        <input type="text" class="form-control" id="phone1" name="phone1" required>
                    </div>

                    <div class="col-md-6">
                        <label for="phone2" class="form-label">Personal Phone</label>
                        <input type="text" class="form-control" id="phone2" name="phone2" required>
                    </div>

                    <div class="col-md-6">
                        <label for="email1" class="form-label">Official Email</label>
                        <input type="email" class="form-control" id="email1" name="email1" required>
                    </div>

                    <div class="col-md-6">
                        <label for="email2" class="form-label">Personal Email</label>
                        <input type="email" class="form-control" id="email2" name="email2" required>
                    </div>
                </div>
            </div>

            <!-- Document Details Section -->
            <div class="card mt-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4>Document Details</h4>
                    <button type="button" class="btn btn-success" id="addDocumentBtn">Add New Document</button>
                </div>
                <div class="card-body" id="documentSection">
                    <div class="document-block row mb-3">
                        <div class="col-md-3">
                            <label for="doc_type_id" class="form-label">Document Type <span class="text-danger">*</span></label>
                            <select id="doc_type_id" name="doc_type_id[]" class="form-select" required>
                                <option value="">Select Document Type</option>
                                <?php
                                $docSql = $conn->query("SELECT id, name FROM doc_types");
                                $docCount = $docSql->num_rows; // Count document types
                                while ($row = $docSql->fetch_assoc()) {
                                    echo "<option value=\"{$row['id']}\">{$row['name']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="doc_number" class="form-label">Document Number</label>
                            <input type="text" class="form-control" id="doc_number" name="doc_number[]" required>
                        </div>
                        <div class="col-md-2">
                            <label for="doc_issue_date" class="form-label">Issue Date</label>
                            <input type="date" class="form-control" id="doc_issue_date" name="doc_issue_date[]" required>
                        </div>
                        <div class="col-md-2">
                            <label for="doc_expiry_date" class="form-label">Expiry Date</label>
                            <input type="date" class="form-control" id="doc_expiry_date" name="doc_expiry_date[]" required>
                        </div>
                        <div class="col-md-3">
                            <label for="doc_attachment" class="form-label">Attachment</label>
                            <input type="file" class="form-control" id="doc_attachment" name="doc_attachment[]" required>
                        </div>
                         <div class="col-md-3">
                            <label for="doc_alert" class="form-label">Alert Days</label>
                            <input type="number" class="form-control" id="doc_alert" name="doc_alert[]">
                        </div>
                        <div class="col-md-1 d-flex align-items-end">
                            <button type="button" class="btn btn-danger remove-btn" style="display: none;">Remove</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Salary Details Section -->
            <div class="card mt-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4>Salary Details</h4>
                    <button type="button" class="btn btn-success" id="addSalaryBtn">Add New Salary</button>
                </div>
                <div class="card-body" id="salarySection">
                    <div class="salary-block row mb-3">
                        <div class="col-md-3">
                            <label for="salary_type_id" class="form-label">Salary Type <span class="text-danger">*</span></label>
                            <select id="salary_type_id" name="salary_type_id[]" class="form-select" required>
                                <option value="">Select Salary Type</option>
                                <?php
                                $salarySql = $conn->query("SELECT id, name FROM salary_types");
                                $salaryCount = $salarySql->num_rows; // Count salary types
                                while ($row = $salarySql->fetch_assoc()) {
                                    echo "<option value=\"{$row['id']}\">{$row['name']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="currency" class="form-label">Currency</label>
                            <select name="currency[]" id="currency" class="form-select" required>
                                <option value="" selected disabled>Select Currency</option>
                                <option value="AED">AED</option>
                                <option value="USD">USD</option>
                                <option value="INR">INR</option>
                                <option value="PKR">PKR</option>
                                <option value="SAR">SAR</option>
                                <option value="EUR">EUR</option>
                                <option value="GBP">GBP</option>
                            </select>
                            <!-- <input type="text" class="form-control" id="currency" name="currency[]"> -->
                        </div>
                        <div class="col-md-3">
                            <label for="basic_salary" class="form-label">Amount</label>
                            <input type="number" class="form-control basic-salary" id="basic_salary" name="basic_salary[]" step="0.01" required>
                        </div>
                        <div class="col-md-1 d-flex align-items-end">
                            <button type="button" class="btn btn-danger remove-btn" style="display: none;">Remove</button>
                        </div>
                    </div>
                </div>
                     <!-- Net Total Field -->
                     <div class="row m-3">
                        <div class="col-md-6">
                            <label for="net_total" class="form-label">Net Total</label>
                            <input type="number" class="form-control" id="net_total" name="net_total" readonly>
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
        <!-- Script for adding/removing Document and Salary blocks -->
        <script>
        const documentSection = document.getElementById('documentSection');
        const addDocumentBtn = document.getElementById('addDocumentBtn');
        const salarySection = document.getElementById('salarySection');
        const addSalaryBtn = document.getElementById('addSalaryBtn');
        const netTotalField = document.getElementById('net_total');

        // Max limits based on DB counts
        const maxDocuments = <?php echo $docCount; ?>;
        const maxSalaries = <?php echo $salaryCount; ?>;

        // Add Document Block
        addDocumentBtn.addEventListener('click', () => {
            const documentBlocks = documentSection.getElementsByClassName('document-block').length;
            if (documentBlocks < maxDocuments) {
                const newDocBlock = documentSection.firstElementChild.cloneNode(true);
                documentSection.appendChild(newDocBlock);
                resetBlockValues(newDocBlock);
                checkRemoveButtons();
            } else {
                alert("You can't add more document blocks!");
            }
        });

        // Add Salary Block
        addSalaryBtn.addEventListener('click', () => {
            const salaryBlocks = salarySection.getElementsByClassName('salary-block').length;
            if (salaryBlocks < maxSalaries) {
                const newSalaryBlock = salarySection.firstElementChild.cloneNode(true);
                salarySection.appendChild(newSalaryBlock);
                resetBlockValues(newSalaryBlock);
                calculateNetTotal();
                checkRemoveButtons();
            } else {
                alert("You can't add more salary blocks!");
            }
        });

        // Remove Document/Salary Block
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('remove-btn')) {
                const block = e.target.closest('.row');
                block.remove();
                calculateNetTotal();
                checkRemoveButtons();
            }
        });

        // Calculate Net Total for Salaries
        document.addEventListener('input', (e) => {
            if (e.target.classList.contains('basic-salary')) {
                calculateNetTotal();
            }
        });

        // Calculate Net Total
        function calculateNetTotal() {
            let netTotal = 0;
            const salaryBlocks = salarySection.querySelectorAll('.basic-salary');
            salaryBlocks.forEach(salaryInput => {
                const salary = parseFloat(salaryInput.value);
                if (!isNaN(salary)) {
                    netTotal += salary;
                }
            });
            netTotalField.value = netTotal.toFixed(2);
        }

        // Reset Block Values
        function resetBlockValues(block) {
            const inputs = block.querySelectorAll('input, select');
            inputs.forEach(input => input.value = '');
        }

        // Show/Hide Remove Buttons
        function checkRemoveButtons() {
            const documentBlocks = documentSection.getElementsByClassName('document-block');
            const salaryBlocks = salarySection.getElementsByClassName('salary-block');

            [...documentBlocks].forEach((block, index) => {
                const removeBtn = block.querySelector('.remove-btn');
                if (index === 0) {
                    removeBtn.style.display = 'none';
                } else {
                    removeBtn.style.display = 'block';
                }
            });

            [...salaryBlocks].forEach((block, index) => {
                const removeBtn = block.querySelector('.remove-btn');
                if (index === 0) {
                    removeBtn.style.display = 'none';
                } else {
                    removeBtn.style.display = 'block';
                }
            });
        }

        // Initial check for remove buttons
        checkRemoveButtons();
    </script>
</body>

</html>