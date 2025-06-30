<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_samesite', 'Lax'); // or 'None' if you use HTTPS
session_start();

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// You can define more admin users here
$admin_users = [
    'admin' => 'adminpass',
    'director' => 'director123',
];

// Validate credentials
if (isset($admin_users[$username]) && $admin_users[$username] === $password) {
    $_SESSION['username'] = $username;
    $_SESSION['role'] = 'admin';

    header('Location: dashboard.php');
    exit();
} else {
    $_SESSION['error'] = 'Invalid login credentials.';
    header('Location: login.php');
    exit();
}
?>
