<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
include('dbcon.php');

// Log login attempts
function logAttempt($user, $status) {
    $logfile = __DIR__ . '/logs/login_attempts.log';
    $entry = date('Y-m-d H:i:s') . " | User: $user | Status: $status\n";
    file_put_contents($logfile, $entry, FILE_APPEND);
}

$response = ['status' => 'error', 'message' => 'Invalid request.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'] ?? '';
    $password = md5($_POST['password'] ?? '');

    $stmt = $pdo->prepare("SELECT * FROM voters WHERE id_number = ? AND password = ? AND account = 'active'");
    $stmt->execute([$student_id, $password]);

    if ($stmt->rowCount() > 0) {
        $voter = $stmt->fetch();
        $_SESSION['poll_voter_id'] = $voter['voters_id'];
        logAttempt($student_id, 'SUCCESS');
        echo json_encode(['status' => 'success']);
        exit;
    } else {
        logAttempt($student_id, 'FAILED');
        echo json_encode(['status' => 'error', 'message' => 'Invalid Student ID, password, or account not active.']);
        exit;
    }
} else {
    echo json_encode($response);
    exit;
}
?>

<!-- login.php HTML section -->
<!DOCTYPE html>
<html>
<head>
    <title>Poll Login</title>
    <link rel="stylesheet" href="assets/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 0; }
        header, footer { background: #003366; color: white; text-align: center; padding: 10px 0; }
        .login-container { max-width: 400px; margin: 50px auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); }
        .form-field { margin-bottom: 15px; }
        input[type="text"], input[type="password"] { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; }
        button { background: #003366; color: white; padding: 10px; width: 100%; border: none; border-radius: 4px; }
        .error-msg { color: red; margin-top: 10px; }
    </style>
</head>
<body>
<header>
    <h1>AAU Opinion Poll System</h1>
</header>
<div class="login-container">
    <h2>Login to Vote</h2>
    <form id="loginForm">
        <div class="form-field">
            <label>Student ID:</label>
            <input type="text" name="student_id" required>
        </div>
        <div class="form-field">
            <label>Password:</label>
            <input type="password" name="password" id="password" required>
        </div>
        <div class="form-field">
            <input type="checkbox" onclick="togglePassword()"> Show Password
        </div>
        <button type="submit">Login</button>
        <div id="response" class="error-msg"></div>
    </form>
</div>
<footer>
    <p>&copy; <?= date('Y') ?> Ambrose Alli University Voting System</p>
</footer>
<script>
    function togglePassword() {
        const pwd = document.getElementById("password");
        pwd.type = pwd.type === "password" ? "text" : "password";
    }

    $('#loginForm').on('submit', function(e) {
        e.preventDefault();
        $.post('login.php', $(this).serialize(), function(data) {
            const res = JSON.parse(data);
            if (res.status === 'success') {
                window.location.href = 'vote/index.php';
            } else {
                $('#response').text(res.message);
            }
        });
    });
</script>
</body>
</html>
