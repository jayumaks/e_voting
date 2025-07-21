<?php
session_start();
include("admin/dbcon.php");

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

            // Use the correct column name: voters_id
            $stmt = $conn->prepare("INSERT INTO votes (candidate_id, voters_id) VALUES (?, ?)");
            $stmt->bind_param("ii", $candidate_id, $voter_id);
            if (!$stmt->execute()) {
                die("Vote insert failed: " . $stmt->error);
            }
            $stmt->close();
        }
    }

    // Mark voter as "Voted" and timestamp
    $now = date("Y-m-d H:i:s");
    $update = $conn->prepare("UPDATE voters SET status = 'Voted', date = ? WHERE voters_id = ?");
    $update->bind_param("si", $now, $voter_id);
    if (!$update->execute()) {
        die("Status update failed: " . $update->error);
    }
    $update->close();

    // Clear session and redirect
    session_destroy();
    header("Location: index.php");
    exit();
} else {
    echo "Session expired or invalid.";
}
