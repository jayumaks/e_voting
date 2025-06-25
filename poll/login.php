<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
include('dbcon.php'); // adjust path if needed

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'];
    $password = md5($_POST['password']); // matching your existing password hash

    $stmt = $pdo->prepare("SELECT * FROM voters WHERE id_number = ? AND password = ? AND account = 'active'");
    $stmt->execute([$student_id, $password]);

    if ($stmt->rowCount() > 0) {
        $voter = $stmt->fetch();
        $_SESSION['poll_voter_id'] = $voter['voters_id'];
        header("Location: vote/index.php");
        exit;
    } else {
        $error = "Invalid Student ID, password, or account not active.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Poll Login</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="container">
    <h2>Login to Vote in the Opinion Poll</h2>
    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="post">
        <label>Student ID:</label><br>
        <input type="text" name="student_id" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit">Login</button>
    </form>
</div>
</body>
</html>
