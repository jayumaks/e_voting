<?php
include("admin/dbcon.php");
session_start();

$voter_id = $_SESSION['voters_id'] ?? null;

// Only proceed if voter ID exists
if (!$voter_id) {
    header("Location: login.php");
    exit();
}

// List all expected session keys and positions
$votes = [
    'pres_id',
    'vp_id',
    'ua_id',
    'ss_id',
    'ea_id',
    'treasurer_id',
    'sg_id',
    'vtr_id',
    'tas_id',
    'ps_id',
    'as_id',
];

// Insert votes into the database
foreach ($votes as $vote_key) {
    if (!empty($_SESSION[$vote_key])) {
        $candidate_id = $_SESSION[$vote_key];
        $conn->query("INSERT INTO `votes` (candidate_id, voters_id) VALUES('$candidate_id', '$voter_id')") or die($conn->error);
    }
}

// Update voter status
$conn->query("UPDATE `voters` SET `status` = 'Voted' WHERE `voters_id` = '$voter_id'") or die($conn->error);

// Clear session only after all operations
session_destroy();

// Redirect to homepage or confirmation
header("Location: index.php");
exit();
?>
