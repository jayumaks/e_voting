<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

require '../admin/dbcon.php';

// PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../mailer/src/PHPMailer.php';
require '../mailer/src/SMTP.php';
require '../mailer/src/Exception.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_number'])) {
    $id_number = trim($_POST['id_number']);

    $stmt = $conn->prepare("SELECT email FROM ids WHERE id_number = ?");
    $stmt->bind_param("s", $id_number);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($email);

    if ($stmt->num_rows === 1) {
        $stmt->fetch();

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = "Invalid email address.";
            header("Location: index.php");
            exit();
        }

        // Generate OTP
        $otp = rand(100000, 999999);
        $_SESSION['otp'] = $otp;
        $_SESSION['email'] = $email;
        $_SESSION['id_number'] = $id_number;

        $at_pos = strpos($email, "@");
        $masked = substr($email, 0, 2) . str_repeat("*", $at_pos - 2) . substr($email, $at_pos);
        $_SESSION['masked_email'] = $masked;

        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'wghp2.wghservers.com'; // Or wghp2.wghservers.com
            $mail->SMTPAuth = true;
            $mail->Username = 'no-reply@voting.aauekpoma.edu.ng'; // use full email
            $mail->Password = 'sRoQ$L%2)l#-jVz-'; // real password

            $mail->SMTPSecure = 'tls'; // Try 'ssl' if this fails
            $mail->Port = 587;

            $mail->setFrom('noreply@aauekpoma.edu.ng', 'AAU E-Voting System');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = "AAU Voting OTP Verification";
            $mail->Body = "<p>Your OTP is: <strong>$otp</strong></p><p>Do not share this code with anyone.</p>";

            // Enable debug output for troubleshooting
            // $mail->SMTPDebug = 2; // Use this temporarily to see errors

            $mail->send();

            $_SESSION['success'] = "OTP sent to your email.";
            header("Location: index.php");
            exit();

        } catch (Exception $e) {
            $_SESSION['error'] = "Mailer Error: " . $mail->ErrorInfo;
            header("Location: index.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "ID not found or no email linked.";
        header("Location: index.php");
        exit();
    }
} else {
    $_SESSION['error'] = "Invalid request.";
    header("Location: index.php");
    exit();
}
