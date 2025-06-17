<?php
require 'admin/dbcon.php';

if (isset($_POST['option_id'])) {
    $option_id = intval($_POST['option_id']);
    $conn->query("UPDATE poll_option SET votes = votes + 1 WHERE id = $option_id");
    header("Location: poll_result.php");
} else {
    echo "No option selected.";
}
?>