<?php
include('../config.php');
$poll = $pdo->query("SELECT * FROM poll LIMIT 1")->fetch();
$options = $pdo->prepare("SELECT * FROM options WHERE poll_id = ?");
$options->execute([$poll['id']]);
?>
<!DOCTYPE html>
<html>
<head><link rel="stylesheet" href="../assets/style.css"></head>
<body>
<div class="container">
<h2>Poll Results: <?= $poll['question'] ?></h2>
<ul>
<?php foreach($options as $opt): ?>
    <li><?= $opt['option_text'] ?> - <?= $opt['votes'] ?> votes</li>
<?php endforeach; ?>
</ul>
</div>
</body>
</html>