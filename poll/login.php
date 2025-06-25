<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
include('../dbcon.php'); // Adjust path if dbcon.php is outside poll folder

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $matric = $_POST['matric_no'];
    $password = md5($_POST['password']); // Same hash as used in main system

    $stmt = $pdo->prepare("SELECT * FROM voters WHERE id_number = ? AND password = ? AND account = 'active'");
    $stmt->execute([$matric, $password]);

    if ($stmt->rowCount() > 0) {
        $voter = $stmt->fetch();
        $_SESSION['poll_voter_id'] = $voter['voters_id'];
        header("Location: vote/index.php");
        exit;
    } else {
        $error = "Invalid login or inactive account.";
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
        <h2>Login to Vote in Poll</h2>
        <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <form method="post">
            <label>Matric Number:</label><br>
            <input type="text" name="matric_no" required><br><br>

            <label>Password:</label><br>
            <input type="password" name="password" required><br><br>

            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
