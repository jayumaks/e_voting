

<?php
session_start();
include('../dbcon.php');
if (!isset($_SESSION['admin'])) { header('Location: login.php'); exit; }

// Handle reset
if (isset($_POST['reset_votes'])) {
    $pdo->exec("UPDATE options SET votes = 0");
    $pdo->exec("UPDATE voters SET voted = 0"); // Optional, if you track voting
    $message = "All votes have been reset.";
}

$poll = $pdo->query("SELECT * FROM poll LIMIT 1")->fetch();
$options = $pdo->prepare("SELECT * FROM options WHERE poll_id = ?");
$options->execute([$poll['id']]);
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        .container { max-width: 800px; margin: auto; padding: 20px; }
        .btn { padding: 10px 20px; background: red; color: white; border: none; cursor: pointer; margin-top: 20px; }
    </style>
</head>
<body>
<div class="container">
    <h2>Poll Report</h2>
    <?php if (!empty($message)) echo "<p style='color: green;'>$message</p>"; ?>
    <p><strong>Question:</strong> <?= htmlspecialchars($poll['question']) ?></p>
    <ul>
    <?php foreach($options as $opt): ?>
        <li><?= htmlspecialchars($opt['option_text']) ?> - <?= $opt['votes'] ?> votes</li>
    <?php endforeach; ?>
    </ul>
    <form method="POST" onsubmit="return confirm('Are you sure you want to reset all votes?');">
        <button type="submit" name="reset_votes" class="btn">Reset All Votes</button>
    </form>
</div>
</body>
</html>
