<?php
session_start();
include('head.php');
include('sess.php');
require_once('admin/dbcon.php');
date_default_timezone_set('Africa/Lagos');
?>

<body>
<?php include 'side_bar.php'; ?>

<div class="container mt-5 pt-5">
    <h2 class="text-center mb-4">🗳️ Review Your Selected Candidates</h2>
    <div class="row justify-content-center">

<?php
$positions = [
    'President' => 'pres_id',
    'VICE PRESIDENT' => 'vp_id',
    'TREASURER' => 'treasurer_id',
    'SECRETARY GENERAL' => 'sg_id',
    'WELFARE' => 'tas_id',
    'PUBLICITY SECRETARY' => 'ps_id',
];

$candidateSummary = [];

// Store selections into session
if (isset($_POST['submit'])) {
    foreach ($positions as $label => $field) {
        $_SESSION[$field] = $_POST[$field] ?? null;
    }
}

// Show selected candidates
foreach ($positions as $label => $field) {
    $candidate_id = $_SESSION[$field] ?? null;
    if (!empty($candidate_id)) {
        $stmt = $conn->prepare("SELECT firstname, lastname, img FROM candidate WHERE candidate_id = ?");
        $stmt->bind_param("i", $candidate_id);
        $stmt->execute();
        $stmt->bind_result($firstname, $lastname, $img);
        if ($stmt->fetch()) {
            $candidateSummary[] = [$label, "$firstname $lastname"];
            echo <<<HTML
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white text-center">
                        <strong>$label</strong>
                    </div>
                    <div class="card-body text-center">
                        <img src="admin/{$img}" alt="Candidate Image" class="img-thumbnail mb-2" width="100" height="100" style="border-radius: 50%;">
                        <h5 class="card-title">{$firstname} {$lastname}</h5>
                    </div>
                </div>
            </div>
HTML;
        }
        $stmt->close();
    }
}
?>

    </div>

    <!-- Summary Table -->
    <div class="row justify-content-center">
        <div class="col-md-8 mt-4">
            <h4 class="text-center">📝 Summary of Selected Candidates</h4>
            <table class="table table-bordered table-striped mt-3">
                <thead class="thead-dark">
                    <tr>
                        <th>Position</th>
                        <th>Candidate Name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($candidateSummary as [$position, $name]): ?>
                        <tr>
                            <td><?= htmlspecialchars($position) ?></td>
                            <td><?= htmlspecialchars($name) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Timestamp -->
    <div class="text-center text-muted mt-3 mb-5">
        <p><strong>Vote Preview Generated:</strong> <?= date("l, jS F Y h:i A") ?></p>
    </div>

    <!-- Confirm Buttons -->
    <div class="text-center mb-5">
        <p class="lead">Are you sure you want to <strong>submit</strong> your votes?</p>
        <a href="submit_vote.php" class="btn btn-success btn-lg mx-2">
            <i class="fa fa-check"></i> Yes, Submit
        </a>
        <a href="vote.php" class="btn btn-danger btn-lg mx-2">
            <i class="fa fa-arrow-left"></i> Go Back
        </a>
    </div>
</div>

<!-- Vote Count Summary -->
<div class="row justify-content-center">
    <div class="col-md-8 mt-5">
        <h4 class="text-center">📊 Total Votes for Selected Candidates</h4>
        <table class="table table-bordered table-hover mt-3">
            <thead class="thead-dark">
                <tr>
                    <th>Position</th>
                    <th>Candidate Name</th>
                    <th>Total Votes</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($positions as $label => $field):
                    $candidate_id = $_SESSION[$field] ?? null;
                    if (!empty($candidate_id)) {
                        $stmt = $conn->prepare("
                            SELECT c.firstname, c.lastname, COUNT(v.vote_id) as total_votes
                            FROM candidate c
                            LEFT JOIN votes v ON c.candidate_id = v.candidate_id
                            WHERE c.candidate_id = ?
                            GROUP BY c.candidate_id
                        ");
                        $stmt->bind_param("i", $candidate_id);
                        $stmt->execute();
                        $stmt->bind_result($fname, $lname, $voteCount);
                        if ($stmt->fetch()):
                ?>
                    <tr>
                        <td><?= htmlspecialchars($label) ?></td>
                        <td><?= htmlspecialchars("$fname $lname") ?></td>
                        <td><?= htmlspecialchars($voteCount) ?></td>
                    </tr>
                <?php
                        endif;
                        $stmt->close();
                    }
                endforeach;
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php include('script.php'); include('footer.php'); ?>
</body>
</html>
