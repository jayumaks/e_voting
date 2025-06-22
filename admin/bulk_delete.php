<?php
require 'dbcon.php';

if (!empty($_POST['delete_ids'])) {
  $ids = $_POST['delete_ids'];

  foreach ($ids as $id) {
    $id = $conn->real_escape_string($id);
    $conn->query("DELETE FROM ids WHERE id_number = '$id'");
  }

  echo "<script>alert('Selected records deleted successfully.'); window.location='YOUR_PAGE.php';</script>";
} else {
  echo "<script>alert('No records selected.'); window.location='YOUR_PAGE.php';</script>";
}
?>
