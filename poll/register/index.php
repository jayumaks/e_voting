<?php include('../dbcon.php'); ?>
<!DOCTYPE html>
<html>
<head><link rel="stylesheet" href="../assets/style.css"></head>
<body>
<div class="container">
<h2>Register to Vote</h2>
<form action="process.php" method="POST">
    <input type="text" name="fullname" placeholder="Full Name" required><br><br>
    <input type="text" name="matric_no" placeholder="Matric Number" required><br><br>
    <button type="submit">Register</button>
</form>
</div>
</body>
</html>