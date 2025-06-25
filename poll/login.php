<?php
session_start();
include('dbcon.php');

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'];
    $password = md5($_POST['password']); // Ensure it matches your DB hashing

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
    <!-- Header / Logo -->
    <header style="background: black; color: white; padding: 15px; text-align: center;">
        <h1 style="margin: 0;">AAU Online Voting System</h1>
    </header>

    <div class="container" style="max-width: 500px; margin: 40px auto;">
        <h2>Login to Vote</h2>

        <?php if (!empty($error)): ?>
            <p style="color:red;"><?php echo $error; ?></p>
        <?php endif; ?>

        <form method="post" action="login.php">
            <label>Student ID:</label><br>
            <input type="text" name="student_id" required><br><br>

            <label>Password:</label><br>
            <input type="password" name="password" required><br><br>

            <button type="submit">Login</button>
        </form>
    </div>

    <!-- Footer -->
    <footer style="background: #333; color: white; text-align: center; padding: 10px; position: fixed; width: 100%; bottom: 0;">
        &copy; <?php echo date('Y'); ?> Ambrose Alli University Voting System
    </footer>
</body>
</html>
