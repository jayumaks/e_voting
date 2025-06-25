<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include('dbcon.php');

// Fetch the latest poll
$poll = $pdo->query("SELECT * FROM poll ORDER BY id DESC LIMIT 1")->fetch();

if (!$poll) {
    die("No poll found.");
}

// Fetch poll options
$options = $pdo->prepare("SELECT * FROM options WHERE poll_id = ?");
$options->execute([$poll['id']]);

// Fetch votes per option
$votes = $pdo->prepare("SELECT option_id, COUNT(*) as total FROM poll_votes WHERE poll_id = ? GROUP BY option_id");
$votes->execute([$poll['id']]);

$voteCounts = [];
foreach ($votes as $v) {
    $voteCounts[$v['option_id']] = $v['total'];
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Poll Results</title>
</head>
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
    <a href="../index.php">Back to Home</a>
</body>
</html>
