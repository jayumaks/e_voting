<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
require_once('admin/dbcon.php');

if (!isset($_SESSION['voters_id'])) {
    header("Location: login.php");
    exit();
}

include('head.php');
?>

<body>
    <div id="wrapper">
        <?php include('side_bar.php'); ?>

        <div id="page-wrapper" style="background-color: #f9f9f9; padding: 30px; min-height: 100vh;">
            <div class="container-fluid">
                <form method="POST" action="vote_result.php">
                    <div class="vote-container">

                        <?php
                        $positions = [
                            'President' => 'pres_id',
                            'Vice President' => 'vp_id',
                            'Treasurer' => 'treasurer_id',
                            'Secretary General' => 'sg_id',
                            'Welfare' => 'tas_id',
                            'Publicity Secretary' => 'ps_id',
                        ];

                        foreach ($positions as $position => $input_name):
                        ?>
                            <div class="row">
                                <div class="col-md-10 col-md-offset-1">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading text-center"><?= strtoupper($position) ?></div>
                                        <div class="panel-body">
                                            <div class="row">
                                                <?php
                                                $stmt = $conn->prepare("SELECT candidate_id, firstname, lastname, gender, year_level, party, img FROM candidate WHERE position = ?");
                                                $stmt->bind_param("s", $position);
                                                $stmt->execute();
                                                $result = $stmt->get_result();

                                                while ($row = $result->fetch_assoc()):
                                                ?>
                                                    <div class="col-sm-6 col-md-4">
                                                        <div class="candidate-card">
                                                            <img src="admin/<?= htmlspecialchars($row['img']) ?>" width="130" height="130" class="candidate-img img-thumbnail">
                                                            <p><strong><?= htmlspecialchars($row['firstname'] . " " . $row['lastname']) ?></strong></p>
                                                            <p>Gender: <?= htmlspecialchars($row['gender']) ?></p>
                                                            <p>Level: <?= htmlspecialchars($row['year_level']) ?></p>
                                                            <p>Party: <?= htmlspecialchars($row['party']) ?></p>
                                                            <label>
                                                                <input type="radio" name="<?= $input_name ?>" value="<?= $row['candidate_id'] ?>" required>
                                                                Give Vote
                                                            </label>
                                                        </div>
                                                    </div>
                                                <?php endwhile;
                                                $stmt->close(); ?>
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
            </div>
        </div>
    </div>

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
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
        }

        .candidate-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
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
</body>
</html>
