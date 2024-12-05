<?php
$conn = new mysqli("localhost", "root", "", "payrol");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

define('BASE_URL','http://locahost/payrol/');
function site_url(){
    return BASE_URL;
}

function employeeExists($employee_id) {
    global $conn;

    // Prepare the query to check employee existence
    $query = "SELECT COUNT(*) as count FROM employee WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $employee_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // Check if the count is greater than 0, meaning the employee exists
    return $row['count'] > 0;
}

function get_supervisor($employee_id) {
    global $conn;
    $query = "SELECT * FROM employee WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $employee_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // return $row['first_name'] .' '. $row['last_name']  ?? '';
    echo json_encode(['name' => $row['first_name'] .' '. $row['last_name'], 'email' => $row['email1']]);
}

// Check if empId is set in the GET request
if (isset($_GET['empId']) && $_GET['empId'] != 0) {
    $empId = intval($_GET['empId']);
    echo get_supervisor($empId);
}