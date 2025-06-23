<?php
include('config.php');
$poll = $pdo->query("SELECT * FROM poll LIMIT 1")->fetch();
$options = $pdo->prepare("SELECT * FROM options WHERE poll_id = ?");
$options->execute([$poll['id']]);
?>
<!DOCTYPE html>
<html>
<head><link rel="stylesheet" href="assets/style.css"></head>
<body>
<div class="container">
<h1>Opinion Poll System</h1>
<p><a href="register/index.php">Register to Vote</a></p>
<p><a href="vote/index.php?matric_no=">Vote</a> (You must enter your matric number manually)</p>
<p><a href="admin/index.php">Admin Login</a></p>
</div>
</body>
</html>