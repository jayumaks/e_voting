<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once('admin/dbcon.php');

if (!isset($_SESSION['voters_id'])) {
    header("Location: login.php");
    exit();
}
?>

<?php include('head.php'); ?>
<?php include('side_bar.php'); ?>
<body>

<style>
    .vote-container {
        margin-top: 80px;
        padding: 20px;
    }

    .candidate-card {
        text-align: center;
        padding: 20px;
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        margin-bottom: 30px;
        background-color: #fff;
        transition: 0.3s;
    }

    .candidate-card:hover {
        transform: scale(1.02);
        box-shadow: 0 4px 15px rgba(0,0,0,0.15);
    }

    .panel-title {
        font-size: 20px;
        font-weight: bold;
    }

    .panel-heading {
        text-align: center;
        font-size: 18px;
        font-weight: 600;
    }

    .candidate-img {
        border-radius: 8px;
        margin-bottom: 10px;
    }

    .submit-btn {
        margin-top: 40px;
    }
</style>

<form method="POST" action="vote_result.php">
<div class="container vote-container">

    <?php
    // Positions to render
    $positions = [
        'President',
        'Vice President',
        'Treasurer',
        'Secretary General',
        'Welfare',
        'PRO'
    ];

    foreach ($positions as $position):
    ?>
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="panel panel-primary">
                    <div class="panel-heading"><?= strtoupper($position) ?></div>
                    <div class="panel-body">
                        <div class="row">

                        <?php
                        $query = $conn->query("SELECT * FROM candidate WHERE position = '$position'") or die($conn->error);
                        $input_name = strtolower(str_replace(' ', '_', $position)) . "_id";

                        while ($row = $query->fetch_assoc()):
                        ?>
                            <div class="col-sm-6">
                                <div class="candidate-card">
                                    <img src="admin/<?= $row['img'] ?>" width="130" height="130" class="candidate-img img-thumbnail">
                                    <p><strong><?= $row['firstname'] . " " . $row['lastname'] ?></strong></p>
                                    <p>Gender: <?= $row['gender'] ?></p>
                                    <p>Level: <?= $row['year_level'] ?></p>
                                    <p>Party: <?= $row['party'] ?></p>
                                    <input type="checkbox" name="<?= $input_name ?>" value="<?= $row['candidate_id'] ?>" class="<?= $input_name ?>">
                                    Give Vote
                                </div>
                            </div>
                        <?php endwhile; ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <div class="row submit-btn">
        <div class="col-md-12 text-center">
            <button class="btn btn-lg btn-success" type="submit" name="submit">Submit Ballot</button>
        </div>
    </div>
</div>
</form>

<?php include('script.php'); ?>
<?php include('footer.php'); ?>

<script type="text/javascript">
// Enforce single selection per position
document.addEventListener("DOMContentLoaded", function () {
    const positions = ['pres_id', 'vice_president_id', 'treasurer_id', 'secretary_general_id', 'welfare_id', 'pro_id'];
    positions.forEach(function (className) {
        const boxes = document.querySelectorAll(`input.${className}`);
        boxes.forEach(function (box) {
            box.addEventListener("change", function () {
                if (this.checked) {
                    boxes.forEach(function (other) {
                        if (other !== box) other.disabled = true;
                    });
                } else {
                    boxes.forEach(function (other) {
                        other.disabled = false;
                    });
                }
            });
        });
    });
});
</script>
</body>
</html>
