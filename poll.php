<?php include('head.php'); include('sess.php'); ?>
<body>
<?php include('side_bar.php'); ?>
<div class="container">
    <h3>Opinion Poll</h3>
    <?php
        require 'admin/dbcon.php';
        $poll = $conn->query("SELECT * FROM poll_question ORDER BY id DESC LIMIT 1")->fetch_assoc();
        $options = $conn->query("SELECT * FROM poll_option WHERE poll_id = {$poll['id']}");
    ?>
    <form method="POST" action="poll_submit.php">
        <h4><?php echo $poll['question']; ?></h4>
        <?php while ($opt = $options->fetch_assoc()) { ?>
            <input type="radio" name="option_id" value="<?php echo $opt['id']; ?>" required>
            <?php echo $opt['option_text']; ?><br>
        <?php } ?>
        <button type="submit" class="btn btn-success">Submit</button>
    </form>
</div>
<?php include('footer.php'); ?>
</body>