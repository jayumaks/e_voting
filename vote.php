<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
require_once('admin/dbcon.php');

if (!isset($_SESSION['voters_id'])) {
    header("Location: login.php");
    exit();
}
?>

<?php include('head.php'); ?>
<body>
    <div id="wrapper"> <!-- Start full page wrapper -->

        <?php include('side_bar.php'); ?>

        <!-- Main Page Content -->
        <div id="page-wrapper" style="background-color: #f9f9f9; padding: 30px; min-height: 100vh;">
            <div class="container-fluid">

                <form method="POST" action="vote_result.php">
                    <div class="vote-container">

                        <?php
                        $positions = ['President', 'Vice President', 'Treasurer', 'Secretary General', 'Welfare', 'PRO'];

                        foreach ($positions as $position):
                        ?>
                            <div class="row">
                                <div class="col-md-10 col-md-offset-1">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading text-center"><?= strtoupper($position) ?></div>
                                        <div class="panel-body">
                                            <div class="row">
                                                <?php
                                                $query = $conn->query("SELECT * FROM candidate WHERE position = '$position'") or die($conn->error);
                                                $input_name = strtolower(str_replace(' ', '_', $position)) . "_id";

                                                while ($row = $query->fetch_assoc()):
                                                ?>
                                                    <div class="col-sm-6 col-md-4">
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
            </div> <!-- /.container-fluid -->
        </div> <!-- /#page-wrapper -->

    </div> <!-- /#wrapper -->

    <?php include('script.php'); ?>
    <?php include('footer.php'); ?>

    <style>
        .vote-container {
            margin-top: 30px;
        }

        .candidate-card {
            text-align: center;
            padding: 20px;
            margin-bottom: 30px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            transition: all 0.3s;
        }

        .candidate-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.15);
        }

        .candidate-img {
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .panel-heading {
            font-size: 18px;
            font-weight: bold;
            background-color: #003366 !important;
            color: white !important;
        }

        .submit-btn {
            margin-top: 50px;
        }
    </style>

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
