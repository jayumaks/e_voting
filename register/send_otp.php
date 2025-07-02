<?php
session_start();
require_once '../admin/dbcon.php';
require_once '../mailer/src/PHPMailer.php'; // Ensure PHPMailer is correctly included

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_number'])) {
    $id_number = trim($_POST['id_number']);

    // Query the student ID from the 'ids' table
    $stmt = $conn->prepare("SELECT email FROM ids WHERE id_number = ?");
    $stmt->bind_param("s", $id_number);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $email = $row['email'];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = "Invalid email address on file.";
            header("Location: index.php");
            exit();
        }

        // Generate and store OTP
        $otp = rand(100000, 999999);
        $_SESSION['otp'] = $otp;
        $_SESSION['email'] = $email;
        $_SESSION['id_number'] = $id_number;

        // Mask the email for UI
        $at_pos = strpos($email, "@");
        $masked = substr($email, 0, 2) . str_repeat("*", $at_pos - 2) . substr($email, $at_pos);
        $_SESSION['masked_email'] = $masked;

        // Send OTP email
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'aaupayslip@aauekpoma.edu.ng'; // Replace
        $mail->Password = 'dvummyogwqcglzgk';    // Replace
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('noreply@aauekpoma.edu.ng', 'AAU E-Voting System');
        $mail->addAddress($email);
        $mail->isHTML(true);

        $mail->Subject = "AAU Voting OTP Verification";
        $mail->Body    = "<p>Your OTP is: <strong>$otp</strong></p><p>Do not share this code with anyone.</p>";

        if ($mail->send()) {
            header("Location: index.php");
            exit();
        } else {
            $_SESSION['error'] = "Failed to send OTP. Please try again.";
            header("Location: index.php");
            exit();
        }

    } else {
        $_SESSION['error'] = "Student ID not found or email not linked.";
        header("Location: index.php");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
