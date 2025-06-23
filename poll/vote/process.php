<?php
include('../dbcon.php');
$matric = $_POST['matric_no'];
$option_id = $_POST['option_id'];
$pdo->prepare("UPDATE options SET votes = votes + 1 WHERE id = ?")->execute([$option_id]);
$pdo->prepare("UPDATE students SET voted = 1 WHERE matric_no = ?")->execute([$matric]);
header('Location: results.php');
?>