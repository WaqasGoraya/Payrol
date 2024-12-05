<?php
require_once('../sessions.php');
require('../connection/conn.php');

if (!isset($_GET['id'])) {
    // Redirect or show an error
    header("Location: /payrol/employees");
    exit();
}

$employee_id = intval($_GET['id']);

// Fetch employee data
$employee_sql = $conn->prepare("SELECT * FROM employee WHERE id = ?");
$employee_sql->bind_param("i", $employee_id);
$employee_sql->execute();
$employee_result = $employee_sql->get_result();

if ($employee_result->num_rows === 0) {
    // Employee not found
    echo "Employee not found";
    exit();
}

$employee = $employee_result->fetch_assoc();

// Fetch employee documents
$doc_sql = $conn->prepare("SELECT * FROM employee_documents WHERE employee_id = ?");
$doc_sql->bind_param("i", $employee_id);
$doc_sql->execute();
$doc_result = $doc_sql->get_result();

$employee_documents = $doc_result->fetch_all(MYSQLI_ASSOC);

// Fetch employee salary details
$salary_sql = $conn->prepare("SELECT * FROM employee_salaries WHERE employee_id = ?");
$salary_sql->bind_param("i", $employee_id);
$salary_sql->execute();
$salary_result = $salary_sql->get_result();

$employee_salaries = $salary_result->fetch_all(MYSQLI_ASSOC);

// Fetch counts for max limits
$docCountSql = $conn->query("SELECT COUNT(*) as count FROM doc_types");
$docCountRow = $docCountSql->fetch_assoc();
$docCount = $docCountRow['count'];

$salaryCountSql = $conn->query("SELECT COUNT(*) as count FROM salary_types");
$salaryCountRow = $salaryCountSql->fetch_assoc();
$salaryCount = $salaryCountRow['count'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Employee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Edit Employee</h1>
            <a href="/payrol/employees" class="btn btn-success">Go Back to List</a>
        </div>
        <form action="../form_handler.php" method="POST" enctype="multipart/form-data">
            <!-- Hidden Fields to Identify the Form Type and Employee ID -->
            <input type="hidden" name="form_type" value="edit_employee">
            <input type="hidden" name="employee_id" value="<?php echo $employee_id; ?>">

            <!-- Personal Details Section -->
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4>Personal Details</h4>
                </div>
                <div class="card-body row">
                    <div class="col-md-6">
                        <label for="emp_image" class="form-label">Employee Photo <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="emp_image" name="emp_image">
                    </div>
                    <div class="col-md-6">
                    <label for="emp_state" class="form-label">Employee Status <span class="text-danger">*</span></label>
                        <div class="form-check form-switch">
                            <label class="form-check-label" for="emp_state">Active/Inactive</label>
                            <input class="form-check-input" type="checkbox" id="emp_state" name="emp_state" value="1" <?php echo $employee['emp_status'] == 1 ? 'checked' : '' ?>>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="last_leave" class="form-label">Last Leave Date<span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="last_leave" value="<?php echo htmlspecialchars($employee['last_leave']); ?>">
                    </div>
                    <!-- First Name -->
                    <div class="col-md-6">
                        <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="first_name" name="first_name"
                            value="<?php echo htmlspecialchars($employee['first_name']); ?>" required>
                    </div>
                    <!-- Last Name -->
                    <div class="col-md-6">
                        <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="last_name" name="last_name"
                            value="<?php echo htmlspecialchars($employee['last_name']); ?>" required>
                    </div>
                    <!-- Department -->
                    <div class="col-md-6">
                        <label for="department_id" class="form-label">Department <span
                                class="text-danger">*</span></label>
                        <select id="department_id" name="department_id" class="form-select" required>
                            <option value="">Select Department</option>
                            <?php
                            $sql = $conn->query("SELECT id, name FROM departments");
                            while ($row = $sql->fetch_assoc()) {
                                $selected = ($employee['department_id'] == $row['id']) ? 'selected' : '';
                                echo "<option value=\"{$row['id']}\" $selected>{$row['name']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <!-- Location -->
                    <div class="col-md-6">
                        <label for="location_id" class="form-label">Location <span class="text-danger">*</span></label>
                        <select id="location_id" name="location_id" class="form-select" required>
                            <option value="">Select Location</option>
                            <?php
                            $sql = $conn->query("SELECT id, name FROM locations");
                            while ($row = $sql->fetch_assoc()) {
                                $selected = ($employee['location_id'] == $row['id']) ? 'selected' : '';
                                echo "<option value=\"{$row['id']}\" $selected>{$row['name']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <!-- Company -->
                    <div class="col-md-6">
                        <label for="company" class="form-label">Company</label>
                        <input type="text" class="form-control" id="company" name="company"
                            value="<?php echo htmlspecialchars($employee['company']); ?>">
                    </div>
                    <!-- Supervisor -->
                    <div class="col-md-6">
                        <label for="supervisor" class="form-label">Supervisor</label>
                        <select name="supervisor_id" id="supervisor" class="form-select">
                            <option value="">Select Supervisor</option>
                            <?php
                            $sql = $conn->query("SELECT id, first_name,last_name from employee");
                            while ($row = $sql->fetch_assoc()) {
                                $selected = ($employee['supervisor_id'] == $row['id']) ? 'selected' : '';
                                echo "<option value=\"{$row['id']}\" $selected>{$row['first_name']} {$row['last_name']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <!-- Designation -->
                    <div class="col-md-6">
                        <label for="designation" class="form-label">Designation</label>
                        <input type="text" class="form-control" id="designation" name="designation"
                            value="<?php echo htmlspecialchars($employee['designation']); ?>">
                    </div>
                    <!-- Date of Join -->
                    <div class="col-md-6">
                        <label for="date_of_join" class="form-label">Date of Join</label>
                        <input type="date" class="form-control" id="date_of_join" name="joining_date"
                            value="<?php echo htmlspecialchars($employee['joining_date']); ?>">
                    </div>
                    <!-- Date of Birth -->
                    <div class="col-md-6">
                        <label for="date_of_birth" class="form-label">Date of Birth</label>
                        <input type="date" class="form-control" id="date_of_birth" name="dob"
                            value="<?php echo htmlspecialchars($employee['dob']); ?>">
                    </div>
                    <!-- Country -->
                    <div class="col-md-6">
                        <label for="country" class="form-label">Country</label>
                        <input type="text" class="form-control" id="country" name="country"
                            value="<?php echo htmlspecialchars($employee['country']); ?>">
                    </div>
                    <!-- City -->
                    <div class="col-md-6">
                        <label for="city" class="form-label">City</label>
                        <input type="text" class="form-control" id="city" name="city"
                            value="<?php echo htmlspecialchars($employee['city']); ?>">
                    </div>
                    <!-- Official Address -->
                    <div class="col-md-6">
                        <label for="address1" class="form-label">Official Address</label>
                        <input type="text" class="form-control" id="address1" name="address1"
                            value="<?php echo htmlspecialchars($employee['address1']); ?>">
                    </div>
                    <!-- Personal Address -->
                    <div class="col-md-6">
                        <label for="address2" class="form-label">Personal Address</label>
                        <input type="text" class="form-control" id="address2" name="address2"
                            value="<?php echo htmlspecialchars($employee['address2']); ?>">
                    </div>
                    <!-- Official Phone -->
                    <div class="col-md-6">
                        <label for="phone1" class="form-label">Official Phone</label>
                        <input type="text" class="form-control" id="phone1" name="phone1"
                            value="<?php echo htmlspecialchars($employee['phone1']); ?>">
                    </div>
                    <!-- Personal Phone -->
                    <div class="col-md-6">
                        <label for="phone2" class="form-label">Personal Phone</label>
                        <input type="text" class="form-control" id="phone2" name="phone2"
                            value="<?php echo htmlspecialchars($employee['phone2']); ?>">
                    </div>
                    <!-- Official Email -->
                    <div class="col-md-6">
                        <label for="email1" class="form-label">Official Email</label>
                        <input type="email" class="form-control" id="email1" name="email1"
                            value="<?php echo htmlspecialchars($employee['email1']); ?>">
                    </div>
                    <!-- Personal Email -->
                    <div class="col-md-6">
                        <label for="email2" class="form-label">Personal Email</label>
                        <input type="email" class="form-control" id="email2" name="email2"
                            value="<?php echo htmlspecialchars($employee['email2']); ?>">
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
                    <!-- Hidden field to track deleted documents -->
                    <input type="hidden" name="delete_docs" id="deleteDocs" value="">

                    <?php
                    // Fetch saved documents from the database
                    $savedDocuments = []; // Replace with actual database query to get existing documents
                    $query = "SELECT * FROM employee_documents WHERE employee_id = ?"; // Adjust the query based on your database schema
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("i", $employee_id); // Assuming $employee_id is available
                    $stmt->execute();
                    $result = $stmt->get_result();

                    while ($doc = $result->fetch_assoc()) {
                    ?>
                        <div class="document-block row mb-3" data-doc-id="<?= $doc['id']; ?>">
                            <!-- Hidden field to track existing document IDs -->
                            <input type="hidden" name="existing_docs[]" value="<?= $doc['id']; ?>">

                            <div class="col-md-3">
                                <label for="doc_type_id" class="form-label">Document Type <span class="text-danger">*</span></label>
                                <select id="doc_type_id" name="doc_type_id[]" class="form-select" required>
                                    <option value="">Select Document Type</option>
                                    <?php
                                    $docSql = $conn->query("SELECT id, name FROM doc_types");
                                    while ($row = $docSql->fetch_assoc()) {
                                        $selected = ($row['id'] == $doc['doc_type_id']) ? 'selected' : '';
                                        echo "<option value=\"{$row['id']}\" $selected>{$row['name']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="doc_number" class="form-label">Document Number</label>
                                <input type="text" class="form-control" id="doc_number" name="doc_number[]" value="<?= htmlspecialchars($doc['doc_number']) ?>">
                            </div>

                            <div class="col-md-2">
                                <label for="doc_issue_date" class="form-label">Issue Date</label>
                                <input type="date" class="form-control" id="doc_issue_date" name="doc_issue_date[]" value="<?= htmlspecialchars($doc['doc_issue_date']) ?>">
                            </div>

                            <div class="col-md-2">
                                <label for="doc_expiry_date" class="form-label">Expiry Date</label>
                                <input type="date" class="form-control" id="doc_expiry_date" name="doc_expiry_date[]" value="<?= htmlspecialchars($doc['doc_expiry_date']) ?>">
                            </div>

                            <div class="col-md-3">
                                <label for="doc_file" class="form-label">Attachment</label>
                                <input type="file" class="form-control" id="doc_attachment" name="doc_file[]" accept="image/*,application/pdf" onchange="previewDocument(this)">
                            </div>

                            <div class="col-md-3 mt-2">
                                <label class="form-label">Preview</label>
                                <div id="doc_preview" class="border p-2" style="min-height: 100px;">
                                    <?php
                                    $fileType = pathinfo($doc['doc_file'], PATHINFO_EXTENSION);
                                    if ($fileType == 'pdf') {
                                        echo "<embed src='" . BASE_URL . $doc['doc_file'] . "' type=\"application/pdf\" width=\"100%\" height=\"100px\" />";
                                    } elseif (in_array($fileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                                        echo "<img src='" . BASE_URL . $doc['doc_file'] . "' class=\"img-fluid\" alt=\"Document Image\" style=\"max-height: 100px;\">";
                                    } else {
                                        echo "<p>{$doc['doc_file']}</p>";
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="doc_alert" class="form-label">Alert Days</label>
                                <input type="number" class="form-control" id="doc_alert" name="doc_alert[]" value="<?= htmlspecialchars($doc['doc_alert']) ?>">
                            </div>

                            <div class="col-md-1 d-flex align-items-end">
                                <button type="button" class="btn btn-danger remove-btn">Remove</button>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>



            <!-- Salary Details Section -->
            <div class="card mt-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4>Salary Details</h4>
                    <button type="button" class="btn btn-success" id="addSalaryBtn">Add New Salary</button>
                </div>
                <div class="card-body" id="salarySection">
                    <?php if (count($employee_salaries) > 0): ?>
                        <?php foreach ($employee_salaries as $salary): ?>
                            <div class="salary-block row mb-3">
                                <div class="col-md-3">
                                    <label for="salary_type_id" class="form-label">Salary Type <span class="text-danger">*</span></label>
                                    <select id="salary_type_id" name="salary_type_id[]" class="form-select" required>
                                        <option value="">Select Salary Type</option>
                                        <?php
                                        $salarySql = $conn->query("SELECT id, name FROM salary_types");
                                        while ($row = $salarySql->fetch_assoc()) {
                                            $selected = ($salary['salary_type_id'] == $row['id']) ? 'selected' : '';
                                            echo "<option value=\"{$row['id']}\" $selected>{$row['name']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="currency" class="form-label">Currency</label>
                                    <select name="currency[]" id="currency" class="form-select">
                                        <option value="">Select Currency</option>
                                        <?php
                                        $currencies = ['AED', 'USD', 'INR', 'PKR', 'SAR', 'EUR', 'GBP'];
                                        foreach ($currencies as $currency) {
                                            $selected = ($salary['currency'] == $currency) ? 'selected' : '';
                                            echo "<option value=\"$currency\" $selected>$currency</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="basic_salary" class="form-label">Amount</label>
                                    <input type="number" class="form-control basic-salary" id="basic_salary" name="basic_salary[]" step="0.01" value="<?php echo htmlspecialchars($salary['basic_salary']); ?>">
                                </div>
                                <div class="col-md-1 d-flex align-items-end">
                                    <button type="button" class="btn btn-danger remove-btn">Remove</button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <!-- If no salaries, show one empty block -->
                        <div class="salary-block row mb-3">
                            <div class="col-md-3">
                                <label for="salary_type_id" class="form-label">Salary Type <span class="text-danger">*</span></label>
                                <select id="salary_type_id" name="salary_type_id[]" class="form-select" required>
                                    <option value="">Select Salary Type</option>
                                    <?php
                                    $salarySql = $conn->query("SELECT id, name FROM salary_types");
                                    while ($row = $salarySql->fetch_assoc()) {
                                        echo "<option value=\"{$row['id']}\">{$row['name']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="currency" class="form-label">Currency</label>
                                <select name="currency[]" id="currency" class="form-select">
                                    <option value="">Select Currency</option>
                                    <option value="AED">AED</option>
                                    <option value="USD">USD</option>
                                    <option value="INR">INR</option>
                                    <option value="PKR">PKR</option>
                                    <option value="SAR">SAR</option>
                                    <option value="EUR">EUR</option>
                                    <option value="GBP">GBP</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="basic_salary" class="form-label">Amount</label>
                                <input type="number" class="form-control basic-salary" id="basic_salary" name="basic_salary[]" step="0.01">
                            </div>
                            <div class="col-md-1 d-flex align-items-end">
                                <button type="button" class="btn btn-danger remove-btn" style="display: none;">Remove</button>
                            </div>
                        </div>
                    <?php endif; ?>
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
                    <button type="submit" class="btn btn-success w-100">Update</button>
                </div>
                <div class="col-6">
                    <button type="reset" class="btn btn-danger w-100">Reset</button>
                </div>
            </div>
        </form>
    </div>
    <!-- Script for adding/removing Salary blocks -->
    <script>
        const salarySection = document.getElementById('salarySection');
        const addSalaryBtn = document.getElementById('addSalaryBtn');
        const netTotalField = document.getElementById('net_total');

        // Max limits based on DB counts
        const maxSalaries = <?php echo $salaryCount; ?>;

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

        // Remove Salary Block
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
            inputs.forEach(input => {
                input.value = '';
            });
        }

        // Show/Hide Remove Buttons
        function checkRemoveButtons() {
            const salaryBlocks = salarySection.getElementsByClassName('salary-block');
            [...salaryBlocks].forEach((block) => {
                const removeBtn = block.querySelector('.remove-btn');
                if (salaryBlocks.length > 1) {
                    removeBtn.style.display = 'block';
                } else {
                    removeBtn.style.display = 'none';
                }
            });
        }

        // Initial check for remove buttons and net total calculation
        checkRemoveButtons();
        calculateNetTotal();
    </script>

    <!-- Script for adding/removing Document blocks with limit -->
    <!-- <script>
        const documentSection = document.getElementById('documentSection');
        const addDocumentBtn = document.getElementById('addDocumentBtn');
        const maxDocuments = <?php echo $docCount; ?>; // Fetch doc count dynamically from the database

        // Add Document Block
        addDocumentBtn.addEventListener('click', () => {
            const documentBlocks = documentSection.getElementsByClassName('document-block').length;
            if (documentBlocks < maxDocuments) {
                // Create the new document block HTML structure
                const newDocumentBlock = `
                <div class="document-block row mb-3">
                    <div class="col-md-3">
                        <label for="doc_type_id" class="form-label">Document Type <span class="text-danger">*</span></label>
                        <select id="doc_type_id" name="doc_type_id[]" class="form-select" required>
                            <option value="">Select Document Type</option>
                            <?php
                            // Fetch document types again for the new document
                            $docSql = $conn->query("SELECT id, name FROM doc_types");
                            while ($row = $docSql->fetch_assoc()) {
                                echo "<option value=\"{$row['id']}\">{$row['name']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="doc_number" class="form-label">Document Number</label>
                        <input type="text" class="form-control" id="doc_number" name="doc_number[]">
                    </div>
                    <div class="col-md-2">
                        <label for="doc_issue_date" class="form-label">Issue Date</label>
                        <input type="date" class="form-control" id="doc_issue_date" name="doc_issue_date[]">
                    </div>
                    <div class="col-md-2">
                        <label for="doc_expiry_date" class="form-label">Expiry Date</label>
                        <input type="date" class="form-control" id="doc_expiry_date" name="doc_expiry_date[]">
                    </div>
                    <div class="col-md-3">
                        <label for="doc_attachment" class="form-label">Attachment</label>
                        <input type="file" class="form-control" id="doc_attachment" name="doc_attachment[]" accept="image/*,application/pdf" onchange="previewDocument(this)">
                    </div>
                    <div class="col-md-3 mt-2">
                        <label class="form-label">Preview</label>
                        <div id="doc_preview" class="border p-2" style="min-height: 100px;">
                            <p>No document uploaded.</p>
                        </div>
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="button" class="btn btn-danger remove-btn">Remove</button>
                    </div>
                </div>
            `;

                // Append the new document block inside the #documentSection
                documentSection.insertAdjacentHTML('beforeend', newDocumentBlock);

                // Add remove functionality for newly added block
                const removeButtons = documentSection.querySelectorAll('.remove-btn');
                removeButtons[removeButtons.length - 1].addEventListener('click', function() {
                    this.closest('.document-block').remove();
                });
            } else {
                alert("You can't add more document blocks!");
            }
        });

        // Document preview function
        function previewDocument(input) {
            const file = input.files[0];
            const previewContainer = input.closest('.document-block').querySelector('#doc_preview');

            if (file) {
                const fileReader = new FileReader();
                fileReader.onload = function(e) {
                    const fileType = file.type;

                    if (fileType.includes('image')) {
                        previewContainer.innerHTML = `<img src="${e.target.result}" class="img-fluid" alt="Document Image" style="max-height: 100px;">`;
                    } else if (fileType.includes('pdf')) {
                        previewContainer.innerHTML = `<embed src="${e.target.result}" type="application/pdf" width="100%" height="100px" />`;
                    } else {
                        previewContainer.innerHTML = `<p>${file.name}</p>`;
                    }
                };
                fileReader.readAsDataURL(file);
            } else {
                previewContainer.innerHTML = '<p>No document uploaded.</p>';
            }
        }

        // Add remove functionality for initially loaded document blocks
        document.querySelectorAll('.remove-btn').forEach(button => {
            button.addEventListener('click', function() {
                this.closest('.document-block').remove();
            });
        });
    </script> -->

    <script>
        const documentSection = document.getElementById('documentSection');
        const addDocumentBtn = document.getElementById('addDocumentBtn');
        const maxDocuments = <?php echo $docCount; ?>; // Fetch doc count dynamically from the database

        // Function to create a new document block
        function createDocumentBlock() {
            const newDocumentBlock = document.createElement('div');
            newDocumentBlock.classList.add('document-block', 'row', 'mb-3');

            newDocumentBlock.innerHTML = `
        <div class="col-md-3">
            <label for="doc_type_id" class="form-label">Document Type <span class="text-danger">*</span></label>
            <select id="doc_type_id" name="doc_type_id[]" class="form-select" required>
                <option value="">Select Document Type</option>
                <?php
                // Fetch document types again for the new document
                $docSql = $conn->query("SELECT id, name FROM doc_types");
                while ($row = $docSql->fetch_assoc()) {
                    echo "<option value='{$row['id']}'>{$row['name']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="col-md-3">
            <label for="doc_number" class="form-label">Document Number</label>
            <input type="text" class="form-control" id="doc_number" name="doc_number[]">
        </div>
        <div class="col-md-2">
            <label for="doc_issue_date" class="form-label">Issue Date</label>
            <input type="date" class="form-control" id="doc_issue_date" name="doc_issue_date[]">
        </div>
        <div class="col-md-2">
            <label for="doc_expiry_date" class="form-label">Expiry Date</label>
            <input type="date" class="form-control" id="doc_expiry_date" name="doc_expiry_date[]">
        </div>
        <div class="col-md-3">
            <label for="doc_attachment" class="form-label">Attachment</label>
            <input type="file" class="form-control" id="doc_attachment" name="doc_attachment[]" accept="image/*,application/pdf" onchange="previewDocument(this)">
        </div>
        <div class="col-md-3 mt-2">
            <label class="form-label">Preview</label>
            <div id="doc_preview" class="border p-2" style="min-height: 100px;">
                <p>No document uploaded.</p>
            </div>
        </div>
        <div class="col-md-1 d-flex align-items-end">
            <button type="button" class="btn btn-danger remove-btn">Remove</button>
        </div>
    `;

            // Add the remove functionality for this block
            newDocumentBlock.querySelector('.remove-btn').addEventListener('click', () => {
                newDocumentBlock.remove();
            });

            // Append the new block to the document section
            documentSection.appendChild(newDocumentBlock);
        }

        // Add Document Block
        addDocumentBtn.addEventListener('click', () => {
            const documentBlocks = documentSection.getElementsByClassName('document-block').length;
            if (documentBlocks < maxDocuments) {
                createDocumentBlock();
            } else {
                alert("You can't add more document blocks!");
            }
        });

        // Document preview function
        function previewDocument(input) {
            const file = input.files[0];
            const previewContainer = input.closest('.document-block').querySelector('#doc_preview');

            if (file) {
                const fileReader = new FileReader();
                fileReader.onload = function(e) {
                    const fileType = file.type;

                    if (fileType.includes('image')) {
                        previewContainer.innerHTML = `<img src="${e.target.result}" class="img-fluid" alt="Document Image" style="max-height: 100px;">`;
                    } else if (fileType.includes('pdf')) {
                        previewContainer.innerHTML = `<embed src="${e.target.result}" type="application/pdf" width="100%" height="100px" />`;
                    } else {
                        previewContainer.innerHTML = `<p>${file.name}</p>`;
                    }
                };
                fileReader.readAsDataURL(file);
            } else {
                previewContainer.innerHTML = '<p>No document uploaded.</p>';
            }
        }

        // Add remove functionality for initially loaded document blocks
        document.querySelectorAll('.remove-btn').forEach(button => {
            button.addEventListener('click', function() {
                this.closest('.document-block').remove();
            });
        });
    </script>

</body>

</html>