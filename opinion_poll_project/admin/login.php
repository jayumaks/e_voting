<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head><link rel="stylesheet" href="../assets/style.css"></head>
<body>
<div class="container">
<h2>Admin Login</h2>
<form method="POST" action="auth.php">
    <input type="text" name="username" placeholder="Username" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button type="submit">Login</button>
</form>
</div>
</body>
</html>