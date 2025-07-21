<?php
include("admin/dbcon.php");
session_start(); // Must be before accessing $_SESSION

// Store session data in local variables BEFORE destroying session
$voter_id = $_SESSION['voters_id'];

$fields = [
    'pres_id',
    'vp_id',
    'tr_id',
    'sg_id',
    'tas_id',
    'ps_id'
];

foreach ($fields as $field) {
    if (!empty($_SESSION[$field])) {
        $candidate_id = $_SESSION[$field];
        $conn->query("INSERT INTO votes (vote_id, candidate_id, voters_id) VALUES('', '$candidate_id', '$voter_id')") or die($conn->error);
    }
}

// Update voter's status
$conn->query("UPDATE voters SET status = 'Voted' WHERE voters_id = '$voter_id'") or die($conn->error);

// Now destroy session
session_destroy();

header("location:index.php");
exit();
?>
