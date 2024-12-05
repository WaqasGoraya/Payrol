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
  </style>
</head>
<body>
  <div class="portal-header">
    <h1>Employee Portal</h1>
  </div>

  <div class="container my-5">
    <ul class="nav nav-tabs" id="employeeTabs" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="remaining-leaves-tab" data-bs-toggle="tab" data-bs-target="#remaining-leaves" type="button" role="tab">Remaining Leaves</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="applied-leaves-tab" data-bs-toggle="tab" data-bs-target="#applied-leaves" type="button" role="tab">Applied Leaves</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="apply-leave-tab" data-bs-toggle="tab" data-bs-target="#apply-leave" type="button" role="tab">Apply Leave</button>
      </li>
    </ul>
    <div class="tab-content mt-4" id="employeeTabContent">
      <div class="tab-pane fade show active" id="remaining-leaves" role="tabpanel">
        <h4>Remaining Leaves</h4>
        <p>You have <strong>10</strong> remaining leaves for this year.</p>
      </div>
      <div class="tab-pane fade" id="applied-leaves" role="tabpanel">
        <h4>Applied Leaves</h4>
        <ul>
          <li>Leave #1: From 2024-01-10 to 2024-01-12 (Approved)</li>
          <li>Leave #2: From 2024-02-15 to 2024-02-16 (Pending)</li>
        </ul>
      </div>
      <div class="tab-pane fade" id="apply-leave" role="tabpanel">
        <h4>Apply for Leave</h4>
        <form>
          <div class="mb-3">
            <label for="leaveFrom" class="form-label">From</label>
            <input type="date" id="leaveFrom" name="leaveFrom" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="leaveTo" class="form-label">To</label>
            <input type="date" id="leaveTo" name="leaveTo" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="reason" class="form-label">Reason</label>
            <textarea id="reason" name="reason" class="form-control" rows="3" required></textarea>
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
