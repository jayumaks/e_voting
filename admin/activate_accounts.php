<?php 
require_once 'dbcon.php';

// Activate voter accounts by updating the correct field
$conn->query("UPDATE voters SET account = 'Active'") or die($conn->error);

// Redirect with feedback
echo "<script> window.location='voters.php?activated=1' </script>";
?>
