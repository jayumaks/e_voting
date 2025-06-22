<?php
require 'dbcon.php';

if (isset($_GET['id'])) {
    $id_number = $conn->real_escape_string($_GET['id']);

    $delete = $conn->query("DELETE FROM ids WHERE id_number = '$id_number'");

    if ($delete) {
        echo "<script>alert('Student deleted successfully.'); window.location = 'CURRENT_PAGE_NAME.php';</script>";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "Invalid request.";
}
?>
