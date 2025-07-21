<?php
include("admin/dbcon.php");
session_start();

$voter_id = $_SESSION['voters_id'] ?? null;

$positions = [
    'pres_id',
    'vp_id',
    'treasurer_id',
    'sg_id',
    'tas_id',
    'ps_id'
];

if ($voter_id) {
    foreach ($positions as $position) {
        if (!empty($_SESSION[$position])) {
            $candidate_id = $_SESSION[$position];
            $conn->query("INSERT INTO votes (candidate_id, voters_id) VALUES ('$candidate_id', '$voter_id')") or die($conn->error);
        }
    }

    // Update status and record vote timestamp
    $now = date("Y-m-d H:i:s");
    $conn->query("UPDATE voters SET status = 'Voted', date = '$now' WHERE voters_id = '$voter_id'") or die($conn->error);

    session_destroy();
    header("location: index.php");
    exit();
} else {
    echo "Session expired or invalid.";
}
?>
