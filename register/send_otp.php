<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once '../admin/dbcon.php';

// Load PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../mailer/src/PHPMailer.php';
require '../mailer/src/SMTP.php';
require '../mailer/src/Exception.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_number'])) {
    $id_number = trim($_POST['id_number']);

    // Prepare query
    $stmt = $conn->prepare("SELECT email FROM ids WHERE id_number = ?");
    if (!$stmt) {
        $_SESSION['error'] = "Database error: " . $conn->error;
        header("Location: index.php");
        exit();
    }

    $stmt->bind_param("s", $id_number);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($email);

    if ($stmt->num_rows === 1) {
        $stmt->fetch();

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = "Invalid email address on file.";
            header("Location: index.php");
            exit();
        }

        // Generate OTP and store in session
        $otp = rand(100000, 999999);
        $_SESSION['otp'] = $otp;
        $_SESSION['email'] = $email;
        $_SESSION['id_number'] = $id_number;

        // Mask the email for display
        $at_pos = strpos($email, "@");
        $masked = substr($email, 0, 2) . str_repeat("*", $at_pos - 2) . substr($email, $at_pos);
        $_SESSION['masked_email'] = $masked;

        // Send email using PHPMailer
        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'mail.aauekpoma.edu.ng'; // or your WGH mail host
            $mail->SMTPAuth = true;
            $mail->Username = 'no-reply@voting.aauekpoma.edu.ng'; // use full email
            $mail->Password = 'sRoQ$L%2)l#-jVz-'; // real password
            $mail->SMTPSecure = 'ssl'; // or 'tls' if you use port 587
            $mail->Port = 465; // or 587 for TLS

            $mail->setFrom('noreply@aauekpoma.edu.ng', 'AAU E-Voting System');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = "AAU Voting OTP Verification";
            $mail->Body = "<p>Your OTP is: <strong>$otp</strong></p><p>Do not share this code with anyone.</p>";


            $mail->send();
            header("Location: index.php");
            exit();
        } catch (Exception $e) {
            $_SESSION['error'] = "Mailer Error: " . $mail->ErrorInfo;
            error_log("Mailer Error: " . $mail->ErrorInfo);
            header("Location: index.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "Student ID not found or email not linked.";
        header("Location: index.php");
        exit();
    }
} else {
    $_SESSION['error'] = "Invalid request.";
    header("Location: index.php");
    exit();
}
