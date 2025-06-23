<?php
session_start();
if (!isset($_SESSION['admin'])) { header('Location: login.php'); exit; }
?>
<!DOCTYPE html>
<html>
<head><link rel="stylesheet" href="../assets/style.css"></head>
<body>
<div class="container">
<?php include('includes/header.php'); ?>
<h2>Admin Dashboard</h2>
<ul>
    <li><a href="voters.php">Voter List</a></li>
    <li><a href="poll_report.php">Poll Report</a></li>
    <li><a href="logout.php">Logout</a></li>
</ul>
</div>
</body>
</html>