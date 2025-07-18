<?php
session_start();
require_once '../admin/dbcon.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error'] = "Invalid access.";
    header("Location: index.php");
    exit();
}

// Ensure OTP verification has occurred
if (!isset($_SESSION['otp_verified']) || $_SESSION['otp_verified'] !== true) {
    $_SESSION['error'] = "Please verify your email with OTP before registering.";
    header("Location: index.php");
    exit();
}

// Validate required POST fields
$required = ['id_number', 'password', 'password1', 'firstname', 'lastname', 'gender', 'prog_study', 'year_level'];
foreach ($required as $field) {
    if (empty($_POST[$field])) {
        $_SESSION['error'] = "All fields are required.";
        header("Location: index.php");
        exit();
    }
}

// Sanitize input
$id_number = $conn->real_escape_string($_POST['id_number']);
$password = $_POST['password'];
$password1 = $_POST['password1'];
$firstname = $conn->real_escape_string($_POST['firstname']);
$lastname = $conn->real_escape_string($_POST['lastname']);
$gender = $conn->real_escape_string($_POST['gender']);
$prog_study = $conn->real_escape_string($_POST['prog_study']);
$year_level = $conn->real_escape_string($_POST['year_level']);
$email = $conn->real_escape_string($_SESSION['email']); // From verified OTP session

// Check password match
if ($password !== $password1) {
    $_SESSION['error'] = "Passwords do not match.";
    header("Location: index.php");
    exit();
}

// Check if ID is already registered
$check = $conn->query("SELECT id_number FROM voters WHERE id_number = '$id_number'");
if ($check && $check->num_rows > 0) {
    $_SESSION['error'] = "This student ID is already registered.";
    header("Location: index.php");
    exit();
}

// Hash password and insert voter
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$insert = $conn->query("INSERT INTO voters
    (id_number, password, firstname, lastname, gender, prog_study, year_level, email, status)
    VALUES
    ('$id_number', '$hashed_password', '$firstname', '$lastname', '$gender', '$prog_study', '$year_level', '$email', 'Inactive')");

if ($insert) {
    // Registration complete
    $_SESSION['success'] = "Registration successful! Await admin activation.";

    // Clear OTP-related session values
    unset($_SESSION['otp']);
    unset($_SESSION['otp_verified']);
    unset($_SESSION['email']);
    unset($_SESSION['masked_email']);
    unset($_SESSION['id_number']);

    header("Location: ../login.php");
    exit();
} else {
    $_SESSION['error'] = "Something went wrong. Please try again.";
    header("Location: index.php");
    exit();
}
