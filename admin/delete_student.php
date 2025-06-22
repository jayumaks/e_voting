<?php
require 'dbcon.php';

if (isset($_GET['id'])) {
  $id = $conn->real_escape_string($_GET['id']);
  $delete = $conn->query("DELETE FROM ids WHERE id_number = '$id'");
  if ($delete) {
    echo "<script>alert('Student deleted successfully.'); window.location='vote.php';</script>";
  } else {
    echo "Error: " . $conn->error;
  }
}
?>
