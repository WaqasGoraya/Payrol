<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer autoload
require 'vendor/autoload.php';

function sendLeaveNotification($supervisorEmail, $supervisorName, $employeeID,$employeeName, $leaveDays, $leaveId, $startDate, $endDate) {
    // Create an instance of PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'mi3-ts10.a2hosting.com'; // Your SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'it@petrofastme.com'; // SMTP username
        $mail->Password   = 'King@@@$$$pfst'; // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('it@petrofastme.com', 'Petrofast');
        $mail->addAddress($supervisorEmail, $supervisorName); // Add recipient

        // Email content
        $approveLink = BASE_URL . "handle_leave.php?action=approve&leave_id=" . urlencode($leaveId)."&emp_id=".urlencode($employeeID);
        $rejectLink =  BASE_URL .  "handle_leave.php?action=reject&leave_id=" . urlencode($leaveId)."&emp_id=".urlencode($employeeID);

        $mail->isHTML(true);
        $mail->Subject = 'Leave Application Notification';
        $mail->Body    = "
            <p>Dear $supervisorName,</p>
            <p>Your employee, <strong>$employeeName</strong>, has applied for leave.</p>
            <p><strong>Total Leave Days:</strong> $leaveDays days</p>
            <p><strong>Start Date:</strong> $startDate</p>
            <p><strong>End Date:</strong> $endDate</p>
            <p>Please take action using the following links:</p>
            <ul>
                <li><a href='$approveLink' class='btn btn-success'>Approve</a></li>
                <li><a href='$rejectLink' class='btn btn-danger'>Reject</a></li>
            </ul>
            <p>Best regards,</p>
            <p>Petrofast</p>
        ";

        // Send the email
        $mail->send();
        // echo 'Email has been sent.';
    } catch (Exception $e) {
        echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

function email_notification($to, $subject, $message){
    // Create an instance of PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'mi3-ts10.a2hosting.com'; // Your SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'it@petrofastme.com'; // SMTP username
        $mail->Password   = 'King@@@$$$pfst'; // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('it@petrofastme.com', 'Petrofast');
        $mail->addAddress($to); // Add recipient

        $mail->isHTML(false);
        $mail->Subject = $subject;
        $mail->Body    = $message;

        // Send the email
        $mail->send();
        return true;
    } catch (Exception $e) {
        echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
    } 
}
