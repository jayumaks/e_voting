<?php
require_once 'dbcon.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_number = $conn->real_escape_string($_GET['id']); // Sanitize input

    $sql = "UPDATE voters SET status = 'Active' WHERE id = '$id_number'";
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
