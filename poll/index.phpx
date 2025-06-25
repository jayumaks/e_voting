<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>


<?php
include('dbcon.php');
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

  <?php if ($poll): ?>
    <h2><?php echo htmlspecialchars($poll['question']); ?></h2>
    <form action="vote/submit_vote.php" method="post">
      <input type="hidden" name="poll_id" value="<?php echo $poll['id']; ?>">
      <?php while ($option = $options->fetch()): ?>
        <div>
          <label>
            <input type="radio" name="option_id" value="<?php echo $option['id']; ?>" required>
            <?php echo htmlspecialchars($option['option_text']); ?>
          </label>
        </div>
      <?php endwhile; ?>
      <button type="submit">Submit Vote</button>
    </form>
  <?php else: ?>
    <p>No poll available right now.</p>
  <?php endif; ?>

  <hr>
  <p><a href="register/index.php">Register to Vote</a></p>
  <p><a href="vote/index.php?matric_no=">Vote</a> (You must enter your matric number manually)</p>
  <p><a href="admin/index.php">Admin Login</a></p>
</div>

</body>
</html>