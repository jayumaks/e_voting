<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once('dbcon.php'); // FIXED path here

// Optional: Verify if an admin is logged in
// if (!isset($_SESSION['admin_id'])) { die('Access denied.'); }

try {
    // Reset votes
    $conn->query("DELETE FROM votes");

    // Reset voter status
    $conn->query("UPDATE voters SET status = 'Unvoted'");

    // Redirect or confirm
    echo "<script>alert('✅ All votes have been reset successfully.'); window.location.href = 'canvassing.php';</script>";
} catch (Exception $e) {
    echo "❌ Reset failed: " . $e->getMessage();
}
?>
