<?php
session_start();
include('dbcon.php');

if (!isset($_SESSION['voter_id'])) {
    header('Location: login.php');
    exit;
}

$poll = $pdo->query("SELECT * FROM poll LIMIT 1")->fetch();
$options = $pdo->prepare("SELECT * FROM options WHERE poll_id = ?");
$options->execute([$poll['id']]);
?>
<!DOCTYPE html>
<html>
<head><title>Poll Voting</title></head>
<body>
<h1><?php echo htmlspecialchars($poll['question']); ?></h1>
<form method="post" action="submit_vote.php">
    <input type="hidden" name="poll_id" value="<?php echo $poll['id']; ?>">
    <?php while ($option = $options->fetch()): ?>
        <label>
            <input type="radio" name="option_id" value="<?php echo $option['id']; ?>" required>
            <?php echo htmlspecialchars($option['option_text']); ?>
        </label><br>
    <?php endwhile; ?>
    <button type="submit">Submit</button>
</form>
</body>
</html>