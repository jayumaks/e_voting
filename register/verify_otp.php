<?php
session_start();
require_once '../admin/dbcon.php';

if (!isset($_POST['otp'])) {
    $_SESSION['error'] = "Invalid access.";
    header("Location: index.php");
    exit();
}

$user_otp = trim($_POST['otp']);
$session_otp = $_SESSION['otp'] ?? '';

// Type-safe comparison
if ((string)$user_otp !== (string)$session_otp) {
    $_SESSION['error'] = "Invalid OTP. Please try again.";
    unset($_SESSION['otp']);
    unset($_SESSION['masked_email']);
    header("Location: index.php");
    exit();
}

// Optionally: Check expiration (if stored)
if (isset($_SESSION['otp_timestamp']) && time() - $_SESSION['otp_timestamp'] > 86400) {
    $_SESSION['error'] = "OTP has expired. Please start over.";
    header("Location: reset.php");
    exit();
}

// OTP is valid — allow user to proceed to registration form
$_SESSION['otp_verified'] = true;
$_SESSION['success'] = "OTP verified. Please complete your registration.";
header("Location: index.php");
exit();
