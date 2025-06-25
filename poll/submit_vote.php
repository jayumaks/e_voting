<?php
session_start();
include('dbcon.php');

$voter_id = $_SESSION['voter_id'] ?? null;
$poll_id = $_POST['poll_id'] ?? null;
$option_id = $_POST['option_id'] ?? null;

if (!$voter_id || !$poll_id || !$option_id) {
    die('Invalid request.');
}

$check = $pdo->prepare("SELECT * FROM poll_votes WHERE voter_id = ? AND poll_id = ?");
$check->execute([$voter_id, $poll_id]);

if ($check->rowCount() > 0) {
    echo "<script>alert('You have already voted.'); window.location='vote.php';</script>";
    exit;
}

$insert = $pdo->prepare("INSERT INTO poll_votes (voter_id, poll_id, option_id) VALUES (?, ?, ?)");
$insert->execute([$voter_id, $poll_id, $option_id]);

echo "<script>alert('Vote submitted successfully!'); window.location='results.php';</script>";
?>