<?php
session_start(); include('../dbcon.php');
if (!isset($_SESSION['admin'])) { header('Location: login.php'); exit; }
$students = $pdo->query("SELECT * FROM students")->fetchAll();
?>
<!DOCTYPE html>
<html>
<head><link rel="stylesheet" href="../assets/style.css"></head>
<body>
<div class="container">
<h2>Registered Voters</h2>
<ul>
<?php foreach($students as $s): ?>
    <li><?= $s['fullname'] ?> (<?= $s['matric_no'] ?>) - <?= $s['voted'] ? 'Voted' : 'Not Voted' ?></li>
<?php endforeach; ?>
</ul>
</div>
</body>
</html>