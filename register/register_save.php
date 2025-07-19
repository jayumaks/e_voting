<?php
session_start();
require_once '../admin/dbcon.php';

// PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../mailer/src/PHPMailer.php';
require '../mailer/src/SMTP.php';
require '../mailer/src/Exception.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error'] = "Invalid access.";
    header("Location: index.php");
    exit();
}

// Ensure OTP verified
if (!isset($_SESSION['otp_verified']) || $_SESSION['otp_verified'] !== true) {
    $_SESSION['error'] = "Please verify your email with OTP before registering.";
    header("Location: index.php");
    exit();
}

// Validate required fields
$required = ['id_number', 'password', 'password1', 'firstname', 'lastname', 'gender', 'prog_study', 'year_level'];
foreach ($required as $field) {
    if (empty($_POST[$field])) {
        $_SESSION['error'] = "All fields are required.";
        header("Location: index.php");
        exit();
    }
}

// Collect inputs
$id_number = $conn->real_escape_string($_POST['id_number']);
$password = $_POST['password'];
$password1 = $_POST['password1'];
$firstname = $conn->real_escape_string($_POST['firstname']);
$lastname = $conn->real_escape_string($_POST['lastname']);
$gender = $conn->real_escape_string($_POST['gender']);
$prog_study = $conn->real_escape_string($_POST['prog_study']);
$year_level = $conn->real_escape_string($_POST['year_level']);
$email = $conn->real_escape_string($_SESSION['email']);

// Confirm password match
if ($password !== $password1) {
    $_SESSION['error'] = "Passwords do not match.";
    header("Location: index.php");
    exit();
}

// Check for duplicate registration
$check = $conn->query("SELECT id_number FROM voters WHERE id_number = '$id_number'");
if ($check && $check->num_rows > 0) {
    $_SESSION['error'] = "This student ID is already registered.";
    header("Location: index.php");
    exit();
}

// Save user
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$insert = $conn->query("INSERT INTO voters (id_number, password, firstname, lastname, gender, prog_study, year_level, email, status)
    VALUES ('$id_number', '$hashed_password', '$firstname', '$lastname', '$gender', '$prog_study', '$year_level', '$email', 'Inactive')");

if ($insert) {
    // Send password by email
    try {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'wghp2.wghservers.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'no-reply@voting.aauekpoma.edu.ng';
        $mail->Password = 'sRoQ$L%2)l#-jVz-';  // Replace with your actual SMTP password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('no-reply@voting.aauekpoma.edu.ng', 'AAU E-Voting System');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = "Your AAU Voting Registration Password";
        $mail->Body = "
            <p>Dear $firstname,</p>
            <p>Your registration was successful.</p>
            <p><strong>Your login password:</strong> <code>$password</code></p>
            <p>Please keep it safe. Do not share with anyone.</p>
            <br><p>Regards,<br>AAU E-Voting Team</p>";

        $mail->send();

    } catch (Exception $e) {
        $_SESSION['error'] = "Registered but failed to send email: " . $mail->ErrorInfo;
        header("Location: ../login.php");
        exit();
    }

    // Final message before redirect
    $_SESSION['success'] = "Registration successful! Your password is: <strong>$password</strong>. Please copy and keep it safe.";

    // Cleanup
    unset($_SESSION['otp'], $_SESSION['otp_verified'], $_SESSION['email'], $_SESSION['masked_email'], $_SESSION['id_number']);

    header("Location: ../login.php");
    exit();
} else {
    $_SESSION['error'] = "Something went wrong: " . $conn->error;
    header("Location: index.php");
    exit();
}
