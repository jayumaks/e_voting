<?php
include('head.php');
include('sess.php');
include('connect.php');

// Fetch all polls
$polls = $conn->query("SELECT * FROM poll_question ORDER BY id DESC") or die($conn->error);
?>

<body>
<?php include 'side_bar.php'; ?>
<div id="wrapper">
    <div class="container" style="margin-top: 20px;">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Opinion Poll Management</h3>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Question</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($poll = $polls->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $poll['id']; ?></td>
                            <td><?php echo htmlspecialchars($poll['question']); ?></td>
                            <td><?php echo $poll['status']; ?></td>
                            <td><?php echo $poll['created_at']; ?></td>
                            <td>
                                <a href="poll_result.php?id=<?php echo $poll['id']; ?>" class="btn btn-sm btn-info">View</a>
                                <a href="poll_toggle.php?id=<?php echo $poll['id']; ?>" class="btn btn-sm btn-warning">Toggle Status</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include('script.php'); include('footer.php'); ?>
</body>
</html>
