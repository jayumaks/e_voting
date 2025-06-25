<?php
include('dbcon.php');
$poll = $pdo->query("SELECT * FROM poll LIMIT 1")->fetch();
$options = $pdo->prepare("SELECT * FROM options WHERE poll_id = ?");
$options->execute([$poll['id']]);

$votes = $pdo->prepare("SELECT option_id, COUNT(*) as total FROM poll_votes WHERE poll_id = ? GROUP BY option_id");
$votes->execute([$poll['id']]);
$voteCounts = [];
foreach ($votes as $v) {
    $voteCounts[$v['option_id']] = $v['total'];
}
?>
<!DOCTYPE html>
<html>
<head><title>Poll Results</title></head>
<body>
<h2>Results: <?php echo htmlspecialchars($poll['question']); ?></h2>
<ul>
<?php while ($option = $options->fetch()): ?>
    <li>
        <?php echo htmlspecialchars($option['option_text']); ?> -
        <?php echo $voteCounts[$option['id']] ?? 0; ?> votes
    </li>
<?php endwhile; ?>
</ul>
<a href="index.php">Back to Home</a>
</body>
</html>