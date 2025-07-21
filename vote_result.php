<?php
include('head.php');
include('sess.php');
require_once('admin/dbcon.php');
session_start();
?>

<body>
<?php include 'side_bar.php'; ?>

<div class="container mt-5 pt-5">
    <h2 class="text-center mb-4">🗳️ Review Your Selected Candidates</h2>
    <div class="row justify-content-center">

<?php
$positions = [
    'PRESIDENT' => 'pres_id',
    'VICE PRESIDENT' => 'vp_id',
    'TREASURER' => 'treasurer_id',
    'SECRETARY GENERAL' => 'sg_id',
    'WELFARE' => 'tas_id',
    'PUBLICITY SECRETARY' => 'ps_id',
];

if (isset($_POST['submit'])) {
    foreach ($positions as $label => $field) {
        $_SESSION[$field] = $_POST[$field] ?? '';
    }
}

// Display each candidate chosen
foreach ($positions as $label => $field) {
    if (!empty($_SESSION[$field])) {
        $stmt = $conn->prepare("SELECT firstname, lastname, img FROM candidate WHERE candidate_id = ?");
        $stmt->bind_param("i", $_SESSION[$field]);
        $stmt->execute();
        $stmt->bind_result($firstname, $lastname, $img);
        if ($stmt->fetch()) {
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

    <!-- Confirm Buttons -->
    <div class="text-center mt-5 mb-4">
        <p class="lead">Are you sure you want to <strong>submit</strong> your votes?</p>
        <a href="submit_vote.php" class="btn btn-success btn-lg mx-2">
            <i class="fa fa-check"></i> Yes, Submit
        </a>
        <a href="vote.php" class="btn btn-danger btn-lg mx-2">
            <i class="fa fa-arrow-left"></i> Go Back
        </a>
    </div>
</div>

<?php include('script.php'); include('footer.php'); ?>
</body>
</html>
