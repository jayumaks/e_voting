<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start session and check login
session_start();
require_once('admin/dbcon.php');

if (!isset($_SESSION['voters_id'])) {
    header("Location: login.php");
    exit();
}
?>

<?php include('head.php'); ?>
<?php include('side_bar.php'); ?>

<!-- Page content starts here -->
<body>
<form method="POST" action="vote_result.php" style="margin-top: 60px;">
<div class="container">
    <!-- Example: President Panel -->
    <div class="col-lg-6">
        <div class="panel panel-primary">
            <div class="panel-heading text-center">PRESIDENT</div>
            <div class="panel-body">
                <?php
                $query = $conn->query("SELECT * FROM candidate WHERE position = 'President'") or die($conn->error);
                while ($row = $query->fetch_assoc()):
                ?>
                    <div id="position">
                        <center>
                            <img src="admin/<?php echo $row['img']; ?>" height="150" width="150" class="img-rounded"><br>
                            <strong>Names:</strong> <?= $row['firstname'] . " " . $row['lastname']; ?><br>
                            <strong>Gender:</strong> <?= $row['gender']; ?><br>
                            <strong>Level:</strong> <?= $row['year_level']; ?><br>
                            <strong>Party:</strong> <?= $row['party']; ?><br>
                            <input type="checkbox" name="pres_id" value="<?= $row['candidate_id']; ?>" class="pres"> Give Vote
                        </center>
                        <hr>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>

    <!-- Repeat similar blocks for VP, Treasurer, etc. -->

    <div class="col-lg-12 text-center">
        <button class="btn btn-success" type="submit" name="submit">Submit Ballot</button>
    </div>
</div>
</form>

<?php include('script.php'); ?>
<?php include('footer.php'); ?>
</body>
</html>
