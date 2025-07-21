<?php
session_start();
require_once './admin/dbcon.php';

// Redirect if voter is not logged in
if (!isset($_SESSION['voters_id'])) {
    header("Location: index.php");
    exit();
}
?>

<?php include('head.php'); ?>
<?php include('side_bar.php'); ?>

<body>
    <div class="container" style="margin-top: 60px;">
        <form method="POST" action="vote_result.php">
            <div class="row">
                <?php
                // Define all positions you want to display
                $positions = [
                    'President',
                    'Vice President',
                    'Treasurer',
                    'Secretary General',
                    'Welfare',
                    'Publicity Secretary'
                ];

                foreach ($positions as $position) {
                    $query = $conn->prepare("SELECT * FROM candidate WHERE position = ?");
                    $query->bind_param("s", $position);
                    $query->execute();
                    $result = $query->get_result();

                    if ($result->num_rows > 0): ?>
                        <div class="col-lg-6">
                            <div class="panel panel-primary">
                                <div class="panel-heading text-center">
                                    <?php echo strtoupper($position); ?>
                                </div>
                                <div class="panel-body text-center">
                                    <?php while ($candidate = $result->fetch_assoc()): ?>
                                        <div class="candidate-block" style="margin-bottom: 20px;">
                                            <img src="admin/<?php echo $candidate['img']; ?>" class="img-thumbnail" height="150" width="150"><br>
                                            <strong><?php echo $candidate['firstname'] . ' ' . $candidate['lastname']; ?></strong><br>
                                            <small>Gender: <?php echo $candidate['gender']; ?> | Level: <?php echo $candidate['year_level']; ?> | Party: <?php echo $candidate['party']; ?></small><br><br>
                                            <input type="radio" name="<?php echo strtolower(str_replace(' ', '_', $position)); ?>_id"
                                                   value="<?php echo $candidate['candidate_id']; ?>" required> Select
                                        </div>
                                    <?php endwhile; ?>
                                </div>
                            </div>
                        </div>
                    <?php
                    endif;
                }
                ?>
            </div>

            <div class="row text-center" style="margin-top: 30px;">
                <button type="submit" class="btn btn-success btn-lg" name="submit">Submit Ballot</button>
            </div>
        </form>
    </div>

    <?php include('script.php'); ?>
</body>
</html>
