<?php
session_start();
require_once('admin/dbcon.php'); // or adjust the path as needed

// Optional: protect this page with an admin session check
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

// Delete all votes
$conn->query("DELETE FROM votes") or die("Failed to reset votes: " . $conn->error);

// Optionally reset all voter statuses
$conn->query("UPDATE voters SET status = 'Unvoted'") or die("Failed to reset voter statuses: " . $conn->error);

// Redirect or show confirmation
echo "<script>alert('✅ All votes have been reset successfully.'); window.location.href = 'canvassing.php';</script>";
?>
