	

<?php
require_once 'dbcon.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $student_id = intval($_GET['id']); // ensure it's an integer

    $update = $conn->query("UPDATE voters SET status = 'Active' WHERE id = $student_id");

    if ($update) {
        echo "<script>window.location='voters.php';</script>";
    } else {
        echo "Database error: " . $conn->error;
    }

} else {
    echo "Error: ID not provided or invalid.";
}
?>

