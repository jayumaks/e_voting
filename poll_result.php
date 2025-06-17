<?php include('head.php'); include('sess.php'); ?>
<body>
<?php include('side_bar.php'); ?>
<div class="container">
    <h3>Poll Results</h3>
    <?php
        require 'admin/dbcon.php';
        $poll = $conn->query("SELECT * FROM poll_question ORDER BY id DESC LIMIT 1")->fetch_assoc();
        $options = $conn->query("SELECT * FROM poll_option WHERE poll_id = {$poll['id']}");
        $total_votes = $conn->query("SELECT SUM(votes) as total FROM poll_option WHERE poll_id = {$poll['id']}")->fetch_assoc()['total'];
    ?>
    <h4><?php echo $poll['question']; ?></h4>
    <ul>
        <?php while ($opt = $options->fetch_assoc()) {
            $percent = ($total_votes > 0) ? round(($opt['votes'] / $total_votes) * 100, 1) : 0;
        ?>
            <li><?php echo $opt['option_text']; ?> - <?php echo $percent; ?>% (<?php echo $opt['votes']; ?> votes)</li>
        <?php } ?>
    </ul>
</div>
<?php include('footer.php'); ?>
</body>