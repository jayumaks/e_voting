<?php
session_start();
require_once '../admin/dbcon.php';
require_once '../mailer/src/PHPMailer.php'; // Adjust path if needed

if (!isset($_POST['otp'], $_POST['id_number'])) {
    $_SESSION['error'] = "Invalid access.";
    header("Location: index.php");
    exit();
}

$user_otp = trim($_POST['otp']);
$session_otp = $_SESSION['otp'] ?? '';

if ($user_otp !== $session_otp) {
    $_SESSION['error'] = "Invalid OTP. Please try again.";
    header("Location: index.php");
    exit();
}

// OTP verified, insert voter record into database
if (isset($_POST['save'])) {
    $id_number = $conn->real_escape_string($_POST['id_number']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $firstname = $conn->real_escape_string($_POST['firstname']);
    $lastname = $conn->real_escape_string($_POST['lastname']);
    $gender = $conn->real_escape_string($_POST['gender']);
    $prog_study = $conn->real_escape_string($_POST['prog_study']);
    $year_level = $conn->real_escape_string($_POST['year_level']);
    $email = $conn->real_escape_string($_SESSION['email']);

    $check = $conn->query("SELECT * FROM voters WHERE id_number = '$id_number'");
    if ($check->num_rows > 0) {
        $_SESSION['error'] = "This ID is already registered.";
        header("Location: index.php");
        exit();
    }

    $insert = $conn->query("INSERT INTO voters (id_number, password, firstname, lastname, gender, prog_study, year_level, email, status) VALUES (
        '$id_number', '$password', '$firstname', '$lastname', '$gender', '$prog_study', '$year_level', '$email', 'Inactive')");

    if ($insert) {
        $_SESSION['success'] = "Registration successful! Await admin activation.";
    } else {
        $_SESSION['error'] = "Something went wrong. Please try again.";
    }
    header("Location: ../login.php");
    exit();
}

// If OTP verified, allow form to continue rendering (in index.php)
$_SESSION['otp_verified'] = true;
header("Location: index.php");
exit();
