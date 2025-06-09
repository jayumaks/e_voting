<?php
require_once 'dbcon.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $student_id = $conn->real_escape_string($_GET['id']); // Sanitize input

    $sql = "UPDATE voters SET status = 'Active' WHERE id = '$student_id'";
    $update = $conn->query($sql);

    if ($update) {
        echo "<script>window.location='voters.php';</script>";
    } else {
        echo "Database error: " . $conn->error;
    }

} else {
    echo "Error: Student ID not provided or invalid.";
}
?>
