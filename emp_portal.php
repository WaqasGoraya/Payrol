<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['employee_id'])) {
  header("Location: emp_login.php");
  exit;
}
include('./connection/conn.php');

// Fetch leave types
$leaveTypes = [];
$sql = "SELECT * FROM leave_types";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $leaveTypes[] = $row;
  }
}
// Fetch employee data (optional)
$employee_id = $_SESSION['employee_id'];
$sql = "SELECT * FROM employee WHERE id = $employee_id";
$stmt = $conn->query($sql);
$employee = $stmt->fetch_assoc();

// Fetch leave data (example, assuming you have a `leaves` table)
$sql_leaves = "SELECT SUM(leave_count) FROM leaves AS total_leaves WHERE employee_id = $employee_id";
$stmt_leaves = $conn->query($sql_leaves);
$remaining_leaves = 0;
if ($stmt_leaves) {
  $leaves = $stmt_leaves->fetch_assoc();
  $remaining_leaves = $leaves['SUM(leave_count)'] ?? 0;
}
//  Fetch leaves request
$sql_leave_req = "SELECT * FROM leave_requests WHERE employee_id = $employee_id";
$stmt_leave_req = $conn->query($sql_leave_req);

// echo"<pre>";
// print_r($stmt_leave_req);
// exit;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $employeeID = $_POST['employee_id'];
  $supervisor = $_POST['supervisor'];
  $leaveType = $_POST['leave_type'];
  $reason = $_POST['reason'];
  $startDate = $_POST['start_date'];
  $endDate = $_POST['end_date'];
  $supervisor_email = $_POST['supervisor_email'];
  $total_days = $_POST['total_days'];

  // Handle file upload
  $attachment = $_FILES['attachment']['name'];
  $attachmentTmp = $_FILES['attachment']['tmp_name'];
  $attachmentPath = 'leaves/uploads/' . basename($attachment);
  move_uploaded_file($attachmentTmp, $attachmentPath);

  if ($supervisor == '' || $supervisor_email == '') {
    $_SESSION['message_type'] = 'danger';
    $_SESSION['message'] = 'You cannt apply leave because supervisor is not assigned!';
    header("Location: {$_SERVER['HTTP_REFERER']}"); // Redirects back to the previous page
    exit;
  }
  // get remaining leaves 
  $leaveQuery = "SELECT remainig_leaves FROM total_leaves WHERE employee_id = $employeeID";
  $leaves = $conn->query($leaveQuery)->fetch_assoc();
  $remainingLeaves = $leaves['remainig_leaves'];


  if ($remainingLeaves <= 0) {
    $_SESSION['message_type'] = 'danger';
    $_SESSION['message'] = 'You cannt apply leave because Your leave balance is 0!';
    header("Location: {$_SERVER['HTTP_REFERER']}"); // Redirects back to the previous page
    exit;
  };

  // get employee name
  $emailQuery = "SELECT * FROM employee WHERE id = $employeeID";
  $employee = $conn->query($emailQuery)->fetch_assoc();

  $employeeName = $employee['first_name'] . ' ' . $employee['last_name'];


  sendLeaveNotification($supervisor_email, $supervisor, $employeeID, $employeeName, $total_days, $leaveType, $startDate, $endDate);

  // Save form data to the database and send email, etc.
  $stmt = $conn->prepare("INSERT INTO leave_requests (employee_id, supervisor, leave_type, reason, start_date, end_date, attachment,total_days) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
  $stmt->bind_param('ssssssss', $employeeID, $supervisor, $leaveType, $reason, $startDate, $endDate, $attachment, $total_days);
  $stmt->execute();
  $stmt->close();
  $_SESSION['message_type'] = 'success';
  $_SESSION['message'] = 'Leave request submitted successfully!';
  header("Location: {$_SERVER['HTTP_REFERER']}"); // Redirects back to the previous page
  exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Employee Portal</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f8f9fa;
    }

    .portal-header {
      background: #007bff;
      color: white;
      padding: 15px;
      text-align: center;
    }

    .container_leave {
      max-width: 600px;
      margin: 50px auto;
      padding: 30px;
      background-color: #ffffff;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
  </style>
</head>

<body>
  <div class="portal-header">
    <h1>Welcome <?php echo $employee['first_name'] . ' ' . $employee['last_name']; ?>(<?php echo $employee['employee_code']; ?>)</h1>
    <a href="logout.php" class="btn btn-danger">Logout</a>
  </div>
  <div class="container my-5">
    <ul class="nav nav-tabs" id="employeeTabs" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="remaining-leaves-tab" data-bs-toggle="tab" data-bs-target="#remaining-leaves" type="button" role="tab">Apply Leave</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="applied-leaves-tab" data-bs-toggle="tab" data-bs-target="#applied-leaves" type="button" role="tab">Applied Leaves</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="apply-leave-tab" data-bs-toggle="tab" data-bs-target="#apply-leave" type="button" role="tab">Remaining Leaves</button>
      </li>
    </ul>
    <div class="tab-content mt-4" id="employeeTabContent">
      <div class="tab-pane fade show active" id="remaining-leaves" role="tabpanel">
        <div class="container_leave">
          <?php


          if (isset($_SESSION['message'])) {
            $messageType = $_SESSION['message_type'] ?? 'info';
            echo "<div class='alert alert-$messageType text-center'>{$_SESSION['message']}</div>";
            unset($_SESSION['message'], $_SESSION['message_type']); // Clear the message after displaying it
          }
          ?>
          <h4>Apply for Leave</h4>
          <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="supervisor_email" id="supervisor_email">
            <input type="hidden" name="total_days" id="total_days">
            <input type="hidden" name="employee_id" value="<?= $employee_id; ?>" />
            <input type="hidden" name="supervisor" value="<?= $employee['supervisor_id']; ?>" />
            <div class="mb-3">
              <label for="leave_type" class="form-label">Leave Type</label>
              <select class="form-select" id="leave_type" name="leave_type" required>
                <option value="">Select Leave Type</option>
                <?php foreach ($leaveTypes as $type): ?>
                  <option value="<?= htmlspecialchars($type['id']) ?>"><?= htmlspecialchars($type['name']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="mb-3">
              <label for="reason" class="form-label">Reason</label>
              <textarea class="form-control" id="reason" name="reason" rows="4" required></textarea>
            </div>
            <div class="mb-3">
              <label for="attachment" class="form-label">Attachment</label>
              <input class="form-control" type="file" id="attachment" name="attachment">
            </div>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" class="form-control" id="start_date" name="start_date" required min="<?php echo date("Y-m-d"); ?>">
              </div>
              <div class="col-md-6 mb-3">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" class="form-control" id="end_date" name="end_date" required min="<?php echo date("Y-m-d"); ?>">
              </div>
            </div>
            <button type="submit" class="btn btn-primary w-100">Submit</button>
          </form>
        </div>
      </div>
      <div class="tab-pane fade" id="applied-leaves" role="tabpanel">
        <h4>Applied Leaves</h4>
        <?php
        if ($stmt_leave_req->num_rows > 0) {
          echo '<ul>';
          $index = 0;
          // Loop through the results
          while ($leave = $stmt_leave_req->fetch_assoc()) {
            ++$index;
            $start_date = $leave['start_date'];
            $end_date = $leave['end_date'];
            $status = $leave['status']; // Assuming status is the column that holds the leave status
            $status_text = $status == 0 ? 'Pending' : ($status == 1 ? 'Approved' : ($status == 2 ? 'Rejected' : 'Unknown'));

            // Display the leave request details
            echo "<li>Leave #$index: From $start_date to $end_date ($status_text)</li>";
          }
          echo '</ul>';
        } else {
          // If no data, display a message
          echo '<p>No data available</p>';
        }
        ?>
      </div>
      <div class="tab-pane fade" id="apply-leave" role="tabpanel">
        <h4>Remaining Leaves</h4>
        <p>You have <strong><?= $remaining_leaves ?></strong> remaining leaves for this year.</p>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script>
    $(document).ready(function() {
      let empId = <?= isset($employee['supervisor_id']) ? json_encode($employee['supervisor_id']) : 'null'; ?>; // Use json_encode for safe PHP-to-JS transfer

      // AJAX request to call the PHP script
      $.ajax({
        url: 'connection/conn.php',
        type: 'GET',
        data: {
          empId: empId
        },
        success: function(response) {
          try {
            let data = JSON.parse(response); // Parse response to JSON
            $("#supervisor").val(data.name || ''); // Set supervisor name
            $("#supervisor_email").val(data.email || ''); // Set supervisor email
          } catch (e) {
            console.error("Error parsing JSON response: ", e.message);
          }
        },
        error: function(xhr, status, error) {
          console.log("Error retrieving supervisor data: ", status, error);
        }
      });
    });

    $('#end_date').on('change', function() {
      const startDate = new Date(document.getElementById('start_date').value);
      if (startDate == 'Invalid Date' || startDate == undefined) {
        alert('Please Select Start Date First!')
        $('#end_date').val(null);
      } else {
        const endDate = new Date(this.value);

        // Calculate the difference in days
        const diffInTime = endDate - startDate;
        const diffInDays = diffInTime / (1000 * 60 * 60 * 24) + 1;

        // Set the calculated days in the leave_days field
        if (diffInDays > 0) {
          $('#total_days').val(diffInDays);
        } else {
          $('#total_days').val(0);
        }
      }
    });
  </script>

</body>

</html>