<?php
include('../dbcon.php');
session_start();

if (!isset($_SESSION['poll_voter_id'])) {
    die("Unauthorized access. Please <a href='../login.php'>login</a>.");
}

$voter_id = $_SESSION['poll_voter_id'];

// Check if the user exists and hasn't voted
$stmt = $pdo->prepare("SELECT * FROM voters WHERE voters_id = ?");
$stmt->execute([$voter_id]);
$user = $stmt->fetch();

if (!$user) {
    die("Voter not found.");
}

if ($user['voted']) {
    die("You have already voted.");
}

// Get the current poll
$poll = $pdo->query("SELECT * FROM poll LIMIT 1")->fetch();
$options = $pdo->prepare("SELECT * FROM options WHERE poll_id = ?");
$options->execute([$poll['id']]);
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../assets/style.css">
    <title>Vote</title>
</head>
<body>
<div class="container">
    <h2><?= htmlspecialchars($poll['question']) ?></h2>
    <form method="POST" action="process.php">
        <?php foreach ($options as $opt): ?>
            <input type="radio" name="option_id" value="<?= $opt['id'] ?>" required>
            <?= htmlspecialchars($opt['option_text']) ?><br>
        <?php endforeach; ?>
        <input type="hidden" name="voter_id" value="<?= $voter_id ?>">
        <br>
        <button type="submit">Submit Vote</button>
    </form>
</div>
</body>
</html>
