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
function handleEmployeeForm($conn) {
    $first_name = $_POST['first_name'] ?? '';
    $last_name = $_POST['last_name'] ?? '';
    $department_id = $_POST['department_id'] ?? '';
    $location_id = $_POST['location_id'] ?? '';
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
    $doc_type_id = $_POST['doc_type_id'] ?? '';
    $doc_number = $_POST['doc_number'] ?? '';
    $doc_issue_date = $_POST['doc_issue_date'] ?? '';
    $doc_expiry_date = $_POST['doc_expiry_date'] ?? '';
    $salary_type_id = $_POST['salary_type_id'] ?? '';
    $basic_salary = $_POST['basic_salary'] ?? '';
    $net_total = $_POST['net_total'] ?? '';

    $query = "
        INSERT INTO employees 
        (first_name, last_name, department_id, location_id, designation, date_of_join, date_of_birth, country, city, address1, address2, phone1, phone2, email1, email2, doc_type_id, doc_number, doc_issue_date, doc_expiry_date, salary_type_id, basic_salary, net_total) 
        VALUES 
        ('$first_name', '$last_name', '$department_id', '$location_id', '$designation', '$date_of_join', '$date_of_birth', '$country', '$city', '$address1', '$address2', '$phone1', '$phone2', '$email1', '$email2', '$doc_type_id', '$doc_number', '$doc_issue_date', '$doc_expiry_date', '$salary_type_id', '$basic_salary', '$net_total')";

    if (mysqli_query($conn, $query)) {
        header('Location:'.BASE_URL.'employees/employees.php');
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
