<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

require_once('admin/dbcon.php'); // Adjust if in a different path

// Optional: check if an admin is logged in
// if (!isset($_SESSION['admin_id'])) { die('Access Denied'); }

try {
    // Delete all votes
    $conn->query("DELETE FROM votes");

    // Reset all voter statuses
    $conn->query("UPDATE voters SET status = 'Unvoted'");

    // Redirect with confirmation
    echo "<script>alert('✅ All votes have been reset.'); window.location = 'canvassing.php';</script>";
} catch (Exception $e) {
    echo "Reset failed: " . $e->getMessage();
}
?>
