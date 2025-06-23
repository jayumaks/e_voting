<?php
include('../dbcon.php');
$matric = $_GET['matric_no'] ?? '';
$stmt = $pdo->prepare("SELECT * FROM students WHERE matric_no = ?");
$stmt->execute([$matric]);
$user = $stmt->fetch();
if (!$user || $user['voted']) {
    die("You are not eligible or already voted.");
}
$poll = $pdo->query("SELECT * FROM poll LIMIT 1")->fetch();
$options = $pdo->prepare("SELECT * FROM options WHERE poll_id = ?");
$options->execute([$poll['id']]);
?>
<!DOCTYPE html>
<html>
<head><link rel="stylesheet" href="../assets/style.css"></head>
<body>
<div class="container">
<h2><?= $poll['question'] ?></h2>
<form method="POST" action="process.php">
    <?php foreach ($options as $opt): ?>
        <input type="radio" name="option_id" value="<?= $opt['id'] ?>" required> <?= $opt['option_text'] ?><br>
    <?php endforeach; ?>
    <input type="hidden" name="matric_no" value="<?= $matric ?>">
    <br><button type="submit">Vote</button>
</form>
</div>
</body>
</html>