<?php
// Force safer session handling across devices
ini_set('session.use_cookies', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_samesite', 'Lax');  // Important for mobile
// Optional: if you're using HTTPS
// ini_set('session.cookie_secure', 1);

session_start();


session_start();

$user = $_POST['username'];
$pass = $_POST['password'];

// Define multiple users here
$users = [
    'admin' => ['password' => 'password', 'redirect' => 'dashboard.php'],
    'Prof. Iniaghe' => ['password' => 'asdfghjkl', 'redirect' => 'dashboard.php'],
    'Dean Of Student' => ['password' => 'zxcvbnm', 'redirect' => 'dashboard.php'],
    'Prof. Ignis' => ['password' => 'qwertyuiop', 'redirect' => 'dashboard.php']
];

// Check credentials
if (isset($users[$user]) && $users[$user]['password'] === $pass) {
    $_SESSION['username'] = $user;
    $_SESSION['role'] = $user;
    header("Location: " . $users[$user]['redirect']);
    exit();
} else {
    echo "<h3 style='color:red;'>Invalid credentials</h3>";
}
?>
