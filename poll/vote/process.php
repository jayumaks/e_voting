<?php
include('../dbcon.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $option_id = $_POST['option_id'];
    $voter_id = $_POST['voter_id'];

    // Check if already voted
    $check = $pdo->prepare("SELECT voted FROM voters WHERE voters_id = ?");
    $check->execute([$voter_id]);
    $row = $check->fetch();

    if ($row && $row['voted']) {
        die("You have already voted.");
    }

    // Update vote count
    $pdo->prepare("UPDATE options SET votes = votes + 1 WHERE id = ?")->execute([$option_id]);

    // Mark user as voted
    $pdo->prepare("UPDATE voters SET voted = 1 WHERE voters_id = ?")->execute([$voter_id]);

    // Redirect to results
    header("Location: ../results.php");
    exit;
}
?>
