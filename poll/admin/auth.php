<?php
session_start();
$user = $_POST['username'];
$pass = $_POST['password'];
if ($user === 'admin' && $pass === 'password') {
    $_SESSION['admin'] = true;
    header('Location: dashboard.php');
} else {
    echo "Invalid credentials";
}
?>