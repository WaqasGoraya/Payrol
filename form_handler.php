<?php
require_once('./db_conn.php');
session_start();
// $_SESSION['message_type'] = '';

// Determine which form was submitted based on the hidden input 'form_type'
$form_type = $_POST['form_type'] ?? '';

switch ($form_type) {
    case 'department':
        handleDepartmentForm($conn); // Pass the MySQLi connection object
        break;
    case 'edit_department':
        handleEditDepartmentForm($conn); // Pass the MySQLi connection object
        break;
    case 'doc_type':
        handleDocTypeForm($conn);
        break;
    case 'edit_doc_type':
        handleEditDocTypeForm($conn);
        break;
    case 'salary_type':
        handleSalaryTypeForm($conn);
        break;
    case 'edit_salary_type':
        handleEditSalaryTypeForm($conn);
        break;
    case 'leave_type':
        handleLeaveTypeForm($conn);
        break;
    case 'update_leave_type':
        handleEditLeaveTypeForm($conn);
        break;
    case 'location':
        handleLocationForm($conn);
        break;
    case 'edit_location':
        handleEditLocationForm($conn);
        break;
    case 'employee':
        handleEmployeeForm($conn);
        break;
    case 'edit_employee':
        editEmployeeForm($conn);
        break;
    default:
        echo "Invalid form submission.";
        break;
}

// Handle Department form
function handleDepartmentForm($conn) {
    $department_name = $_POST['name'] ?? '';

    if ($department_name) {
        $query = "INSERT INTO departments (name) VALUES ('$department_name')";
        if (mysqli_query($conn, $query)) {
            $_SESSION['message_type'] = 'success';
            $_SESSION['message'] = 'Department Added Successfully!';
            header('Location:'.BASE_URL.'departments/department.php');
            exit();
        } else {
            $_SESSION['message_type'] = 'error';
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        $_SESSION['message_type'] = 'error';
        $_SESSION['message'] = 'Something went wrong! Please try again.';
        header('Location:'.BASE_URL.'departments/add_department.php');
        exit();
    }
}
// Handle Edit Department form
function handleEditDepartmentForm($conn) {
    $department_id = $_POST['department_id'] ?? '';
    $department_name = $_POST['department_name'] ?? '';

    if ($department_id && $department_name) {
        // Create SQL query to update the salary type
        $query = "UPDATE departments SET name = '$department_name' WHERE id = $department_id";
        $result = mysqli_query($conn, $query);

        if ($result) {
            // Redirect to the salary types list page with a success message
            $_SESSION['message_type'] = 'success';
            $_SESSION['message'] = 'Department Updated Successfully!';
            header('Location:'.BASE_URL.'departments/department.php');
            exit();
        } else {
            echo "Error updating salary type: " . mysqli_error($conn);
        }
    } else {
        $_SESSION['message_type'] = 'error';
        $_SESSION['message'] = 'Department name and ID are required..';
        header('Location:'.BASE_URL.'departments/add_department.php');
        exit();
    }
}


// Handle Document Type form
function handleDocTypeForm($conn) {
    $doc_type_name = $_POST['doc_type_name'] ?? '';

    if ($doc_type_name) {
        $query = "INSERT INTO doc_types (name) VALUES ('$doc_type_name')";
        if (mysqli_query($conn, $query)) {
            $_SESSION['message_type'] = 'success';
            $_SESSION['message'] = 'Document Type Added Successfully!';
            header('Location:'.BASE_URL.'documents/documents.php');
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo ".";
        $_SESSION['message_type'] = 'error';
        $_SESSION['message'] = 'Document type name is required';
        header('Location:'.BASE_URL.'documents/add_dpc_type.php');
        exit();
    }
}
// Handle Edit Document Type form
function handleEditDocTypeForm($conn) {
    $document_id = $_POST['document_id'] ?? '';
    $document_name = $_POST['document_name'] ?? '';

    if ($document_id && $document_name) {
        $query = "UPDATE doc_types SET name = '$document_name' WHERE id = $document_id";
        if(mysqli_query($conn, $query)) {
            $_SESSION['message_type'] = 'success';
        $_SESSION['message'] = 'Document type updated successfully.';
        header('Location:' .BASE_URL. 'documents/documents.php');
        exit();
        }
    } else {
        $_SESSION['message'] = 'Document type name is required.';
        $_SESSION['message_type'] = 'error';
        header('Location:' .BASE_URL. 'documents/edit_doc_type.php?id=' . urlencode($document_id));
        exit();
    }
}

// Handle Salary Type form
function handleSalaryTypeForm($conn) {
    $salary_type_name = $_POST['salary_type_name'] ?? '';

    if ($salary_type_name) {
        $query = "INSERT INTO salary_types (name) VALUES ('$salary_type_name')";
        if (mysqli_query($conn, $query)) {
            $_SESSION['message_type'] = 'success';
            $_SESSION['message'] = 'Salary Type Added Successfully!';
            header('Location:'.BASE_URL.'salaries/salaries.php');
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Salary type name is required.";
    }
}
// Handle Edit Salary type
function handleEditSalaryTypeForm($conn){
    $salary_type_id = $_POST['salary_type_id'] ?? '';
    $salary_type_name = $_POST['salary_type_name'] ?? '';

    if ($salary_type_id && $salary_type_name) {
        // Create SQL query to update the salary type
        $query = "UPDATE salary_types SET name = '$salary_type_name' WHERE id = $salary_type_id";
        $result = mysqli_query($conn, $query);

        if ($result) {
            // Redirect to the salary types list page with a success message
            $_SESSION['message_type'] = 'success';
            $_SESSION['message'] = 'Salary Type Updated Successfully!';
            header('Location:'.BASE_URL.'salaries/salaries.php');
            exit();
        } else {
            echo "Error updating salary type: " . mysqli_error($conn);
        }
    } else {
        $_SESSION['message_type'] = 'error';
        echo "Salary type name and ID are required.";
    }
}
// Handle Add Leave Type
function handleLeaveTypeForm($conn){
    // Add Leave Type
    $leave_type_name = $_POST['leave_type_name'] ?? '';

    if ($leave_type_name) {
        $query = "INSERT INTO leave_types (name) VALUES ('$leave_type_name')";
        if (mysqli_query($conn, $query)) {
            $_SESSION['message_type'] = 'success';
            $_SESSION['message'] = 'Salary Type Added Successfully!';
            header('Location:'.BASE_URL.'leaves/leave_types.php');
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        $_SESSION['message'] = 'Leave type name is required.';
        $_SESSION['message_type'] = 'error';
        header('Location:'.BASE_URL.'leaves/add_leave_type.php');
        exit();
    }
}
// Handle Edit Leave Type
function handleEditLeaveTypeForm($conn){
    
    $leave_type_id = $_POST['leave_type_id'] ?? '';
    $leave_type_name = $_POST['leave_type_name'] ?? '';

    if ($leave_type_id && $leave_type_name) {
        $query = "UPDATE leave_types SET name = '$leave_type_name' WHERE id = $leave_type_id";
        if(mysqli_query($conn, $query)) {
        $_SESSION['message'] = 'Leave type updated successfully.';
        $_SESSION['message_type'] = 'success';
        header('Location:' .BASE_URL. 'leaves/leave_types.php');
        exit();
        }
    } else {
        $_SESSION['message'] = 'leave type name are required.';
        $_SESSION['message_type'] = 'error';
        header('Location:' .BASE_URL. 'leaves/edit_leave_type.php?id=' . urlencode($leave_type_id));
        exit();
    }
}
// Handle Location form
function handleLocationForm($conn) {
    $location_name = $_POST['location_name'] ?? '';

    if ($location_name) {
        $query = "INSERT INTO locations (name) VALUES ('$location_name')";
        if (mysqli_query($conn, $query)) {
            $_SESSION['message_type'] = 'success';
            $_SESSION['message'] = 'Location Added Successfully!';
            header('Location:'.BASE_URL.'locations/location.php');
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        $_SESSION['message_type'] = 'error';
        $_SESSION['message'] = 'Location name is required.';
        header('Location:'.BASE_URL.'locations/add_location.php');
        exit();
    }
}
// Handle Edit Location form
function handleEditLocationForm($conn) {
    $location_id = $_POST['location_id'] ?? '';
    $location_name = $_POST['location_name'] ?? '';

    if ($location_id && $location_name) {
        $query = "UPDATE locations SET name = '$location_name' WHERE id = $location_id";
        if(mysqli_query($conn, $query)) {
        $_SESSION['message'] = 'Location updated successfully.';
        $_SESSION['message_type'] = 'success';
        header('Location:' .BASE_URL. 'locations/location.php');
        exit();
        }
    } else {
        $_SESSION['message'] = 'location name is required.';
        $_SESSION['message_type'] = 'error';
        header('Location:' .BASE_URL. 'locations/edit_location.php?id=' . urlencode($location_id));
        exit();
    }
}
// Handle Employee form
function handleEmployeeForm($conn)
{

    $first_name = $_POST['first_name'] ?? '';
    $last_name = $_POST['last_name'] ?? '';
    $last_leave = $_POST['last_leave'] ?? '';
    $department_id = $_POST['department_id'] ?? '';
    $location_id = $_POST['location_id'] ?? '';
    $company = $_POST['company'] ?? '';
    $supervisor_id = $_POST['supervisor_id'] ?? '';
    $designation = $_POST['designation'] ?? '';
    $date_of_join = $_POST['date_of_join'] ?? '';
    $date_of_birth = $_POST['date_of_birth'] ?? '';
    $country = $_POST['country'] ?? '';
    $city = $_POST['city'] ?? '';
    $address1 = $_POST['address1'] ?? '';
    $address2 = $_POST['address2'] ?? '';
    $phone1 = $_POST['phone1'] ?? '';
    $phone2 = $_POST['phone2'] ?? '';
    $email1 = $_POST['email1'] ?? '';
    $email2 = $_POST['email2'] ?? '';

    if(isset($_FILES['emp_image'])){
                    // Handle document file upload
                    $img_name = $_FILES['emp_image']['name'];
                    $img_tmp = $_FILES['emp_image']['tmp_name'];
                    // Generate a unique file name using time() function
                    $img_new_name = time() . '_' . basename($img_name);
                    $img_path = 'uploads/' . $img_new_name;

                    move_uploaded_file($img_tmp, $img_path);
    }
        // Get the last employee code from the database
        $result = $mysqli->query("SELECT MAX(employee_code) AS last_code FROM employee");
        $row = $result->fetch_assoc();
        $lastCode = isset($row['last_code']) ? intval($row['last_code']) : 0000;

        // Generate the new employee code
        $newEmployeeCode = $lastCode + 1;

        // Generate a random password
        $password = bin2hex(random_bytes(8)); // Generates a 16-character random password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT); // Hash the password
    // Insert into employee table
    $sql = "INSERT INTO employee (emp_image,last_leave,first_name, last_name, department_id, location_id, designation, company,supervisor_id,joining_date, dob, country, city, address1, address2, phone1, phone2, email1, email2,employee_code,password) 
    VALUES ('$img_path','$last_leave','$first_name', '$last_name', '$department_id', '$location_id', '$designation', '$company','$supervisor_id','$date_of_join', '$date_of_birth', '$country', '$city', '$address1', '$address2', '$phone1', '$phone2', '$email1', '$email2','$newEmployeeCode','$hashedPassword')";


    if ($conn->query($sql) === TRUE) {

        $employee_id = $conn->insert_id; // Get the inserted employee ID

        // Saving Document Blocks
        foreach ($_POST['doc_type_id'] as $key => $doc_type) {
            $doc_number = mysqli_real_escape_string($conn, $_POST['doc_number'][$key]);
            $doc_issue_date = mysqli_real_escape_string($conn, $_POST['doc_issue_date'][$key]);
            $doc_expiry_date = mysqli_real_escape_string($conn, $_POST['doc_expiry_date'][$key]);
            $doc_alert_days = mysqli_real_escape_string($conn, $_POST['doc_alert'][$key]);

            // Handle document file upload
            $doc_file_name = $_FILES['doc_attachment']['name'][$key];
            $doc_file_tmp = $_FILES['doc_attachment']['tmp_name'][$key];
            // Generate a unique file name using time() function
            $doc_file_new_name = time() . '_' . basename($doc_file_name);
            $doc_file_path = 'uploads/' . $doc_file_new_name;

            if (move_uploaded_file($doc_file_tmp, $doc_file_path)) {
                // Insert into employee_documents table
                $sql = "INSERT INTO employee_documents (employee_id, doc_type_id, doc_number, doc_issue_date, doc_expiry_date, doc_file,doc_alert_days)
                        VALUES ('$employee_id', '$doc_type', '$doc_number', '$doc_issue_date', '$doc_expiry_date', '$doc_file_path','$doc_alert_days')";
                $conn->query($sql);
            } else {
                echo "Error uploading document file.";
            }
        }

        // Saving Salary Blocks
        foreach ($_POST['salary_type_id'] as $key => $salary_type) {
            $currency = mysqli_real_escape_string($conn, $_POST['currency'][$key]);
            $basic_salary = mysqli_real_escape_string($conn, $_POST['basic_salary'][$key]);
            $net_total = mysqli_real_escape_string($conn, $_POST['net_total']);

            // Insert into employee_salaries table
            $sql = "INSERT INTO employee_salaries (employee_id, salary_type_id, currency, basic_salary, net_total)
                    VALUES ('$employee_id', '$salary_type', '$currency', '$basic_salary', '$net_total')";
            $conn->query($sql);
        }

        echo "Employee data saved successfully!";
        header('Location:' . BASE_URL . 'employees');
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
// Edit Employee Form
function editEmployeeForm($conn)
{
    $employee_id = $_POST['employee_id'];
    // Fetch form data
        $last_leave = $_POST['last_leave'] ?? '';
    $emp_status = isset($_POST['emp_state']) ? 1 : 0;
    $first_name = $_POST['first_name'] ?? '';
    $last_name = $_POST['last_name'] ?? '';
    $department_id = $_POST['department_id'] ?? '';
    $location_id = $_POST['location_id'] ?? '';
    $company = $_POST['company'] ?? '';
    $supervisor_id = $_POST['supervisor_id'] ?? '';
    $designation = $_POST['designation'] ?? '';
    $date_of_join = $_POST['joining_date'] ?? '';
    $date_of_birth = $_POST['dob'] ?? '';
    $country = $_POST['country'] ?? '';
    $city = $_POST['city'] ?? '';
    $address1 = $_POST['address1'] ?? '';
    $address2 = $_POST['address2'] ?? '';
    $phone1 = $_POST['phone1'] ?? '';
    $phone2 = $_POST['phone2'] ?? '';
    $email1 = $_POST['email1'] ?? '';
    $email2 = $_POST['email2'] ?? '';
    
       if(isset($_FILES['emp_image'])){
        // Handle document file upload
        $img_name = $_FILES['emp_image']['name'];
        $img_tmp = $_FILES['emp_image']['tmp_name'];
        // Generate a unique file name using time() function
        $img_new_name = time() . '_' . basename($img_name);
        $img_path = 'uploads/' . $img_new_name;

        move_uploaded_file($img_tmp, $img_path);
            // Update employee data
    $sql = "UPDATE employee 
            SET emp_image='$img_path',last_leave = '$last_leave',emp_status = '$emp_status', first_name='$first_name', last_name='$last_name', department_id='$department_id', 
                location_id='$location_id', designation='$designation', company='$company', 
                supervisor_id='$supervisor_id', joining_date='$date_of_join', dob='$date_of_birth', 
                country='$country', city='$city', address1='$address1', address2='$address2', 
                phone1='$phone1', phone2='$phone2', email1='$email1', email2='$email2' 
            WHERE id='$employee_id'";
}else{
        // Update employee data
    $sql = "UPDATE employee 
            SET last_leave = '$last_leave',emp_status = '$emp_status', first_name='$first_name', last_name='$last_name', department_id='$department_id', 
                location_id='$location_id', designation='$designation', company='$company', 
                supervisor_id='$supervisor_id', joining_date='$date_of_join', dob='$date_of_birth', 
                country='$country', city='$city', address1='$address1', address2='$address2', 
                phone1='$phone1', phone2='$phone2', email1='$email1', email2='$email2' 
            WHERE id='$employee_id'";
}



    if ($conn->query($sql) === TRUE) {
        // Handle document updates
        handleDocumentBlocks($conn, $employee_id);

        // Handle salary updates
        handleSalaryBlocks($conn, $employee_id);

        echo "Employee data updated successfully!";
        header('Location:' . BASE_URL . 'employees');
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

function handleDocumentBlocks($conn, $employee_id)
{
    // Step 1: Track all existing documents before the form submission
    $existingDocs = $_POST['existing_docs'] ?? []; // Hidden field storing current document IDs

    // Get all document IDs from the database related to the employee
    $sql = "SELECT id, doc_file FROM employee_documents WHERE employee_id = '$employee_id'";
    $result = $conn->query($sql);
    $existingDocRecords = [];

    while ($row = $result->fetch_assoc()) {
        $existingDocRecords[$row['id']] = $row['doc_file'];
    }

    // Step 2: Process each existing document (if not removed in the form)
    foreach ($existingDocs as $key => $doc_id) {
        if (!isset($existingDocRecords[$doc_id])) {
            continue; // Skip if the document isn't in the database
        }

        // Update the document information in the database
        $doc_type = mysqli_real_escape_string($conn, $_POST['doc_type_id'][$key]);
        $doc_number = mysqli_real_escape_string($conn, $_POST['doc_number'][$key]);
        $doc_issue_date = mysqli_real_escape_string($conn, $_POST['doc_issue_date'][$key]);
        $doc_expiry_date = mysqli_real_escape_string($conn, $_POST['doc_expiry_date'][$key]);
        $doc_alert_days = mysqli_real_escape_string($conn, $_POST['doc_alert'][$key]);

        $sql = "UPDATE employee_documents 
                SET doc_type_id='$doc_type', doc_number='$doc_number', doc_issue_date='$doc_issue_date', doc_expiry_date='$doc_expiry_date',doc_alert_days = '$doc_alert_days' 
                WHERE id='$doc_id' AND employee_id='$employee_id'";
        $conn->query($sql);

        // Remove this document from the list of existing ones (meaning it was not removed)
        unset($existingDocRecords[$doc_id]);
    }

    // Step 3: Handle the removal of deleted documents (not in form anymore)
    foreach ($existingDocRecords as $doc_id => $doc_file) {
        // Delete from database
        $sql = "DELETE FROM employee_documents WHERE id='$doc_id' AND employee_id='$employee_id'";
        $conn->query($sql);

        // Delete the file from the server
        if (file_exists($doc_file)) {
            unlink($doc_file);
        }
    }

    // Step 4: Handle new document uploads (files uploaded in the form)
    if (isset($_FILES['doc_attachment']['name']) && !empty($_FILES['doc_attachment']['name'][0])) {
        foreach ($_POST['doc_type_id'] as $key => $doc_type) {
            // Skip processing for existing documents
            if (!empty($_POST['doc_id'][$key])) {
                continue;
            }

            $doc_number = mysqli_real_escape_string($conn, $_POST['doc_number'][$key]);
            $doc_issue_date = mysqli_real_escape_string($conn, $_POST['doc_issue_date'][$key]);
            $doc_expiry_date = mysqli_real_escape_string($conn, $_POST['doc_expiry_date'][$key]);

            // Handle document file upload
            $doc_file_name = $_FILES['doc_attachment']['name'][$key];
            $doc_file_tmp = $_FILES['doc_attachment']['tmp_name'][$key];
            $doc_file_new_name = time() . '_' . basename($doc_file_name);
            $doc_file_path = 'uploads/' . $doc_file_new_name;

            if (move_uploaded_file($doc_file_tmp, $doc_file_path)) {
                // Insert new document record
                $sql = "INSERT INTO employee_documents (employee_id, doc_type_id, doc_number, doc_issue_date, doc_expiry_date, doc_file) 
                        VALUES ('$employee_id', '$doc_type', '$doc_number', '$doc_issue_date', '$doc_expiry_date', '$doc_file_path')";
                $conn->query($sql);
            }
        }
    }
}



// Handle salary blocks (insert, update, delete)
function handleSalaryBlocks($conn, $employee_id)
{
    $existingSalaries = $_POST['existing_salaries'] ?? [];

    // Get all existing salary IDs from the database
    $sql = "SELECT id FROM employee_salaries WHERE employee_id = '$employee_id'";
    $result = $conn->query($sql);
    $existingSalaryRecords = [];

    while ($row = $result->fetch_assoc()) {
        $existingSalaryRecords[$row['id']] = $row['id'];
    }

    // Loop through each salary from the form and update/add new ones
    foreach ($_POST['salary_type_id'] as $key => $salary_type) {
        $currency = mysqli_real_escape_string($conn, $_POST['currency'][$key]);
        $basic_salary = mysqli_real_escape_string($conn, $_POST['basic_salary'][$key]);
        $net_total = mysqli_real_escape_string($conn, $_POST['net_total']);

        // If salary ID exists, update the record
        if (!empty($_POST['salary_id'][$key])) {
            $salary_id = $_POST['salary_id'][$key];
            $sql = "UPDATE employee_salaries 
                    SET salary_type_id='$salary_type', currency='$currency', basic_salary='$basic_salary', net_total='$net_total' 
                    WHERE id='$salary_id' AND employee_id='$employee_id'";
            $conn->query($sql);
            unset($existingSalaryRecords[$salary_id]); // Remove from list of records to be deleted
        } else {
            // Insert new salary block
            $sql = "INSERT INTO employee_salaries (employee_id, salary_type_id, currency, basic_salary, net_total) 
                    VALUES ('$employee_id', '$salary_type', '$currency', '$basic_salary', '$net_total')";
            $conn->query($sql);
        }
    }

    // Delete removed salary blocks
    foreach ($existingSalaryRecords as $salary_id) {
        // Delete from database
        $sql = "DELETE FROM employee_salaries WHERE id='$salary_id' AND employee_id='$employee_id'";
        $conn->query($sql);
    }
}
?>
