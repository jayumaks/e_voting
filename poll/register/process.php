<?php
include('../dbcon.php');
$fullname = $_POST['fullname'];
$matric = $_POST['matric_no'];
$stmt = $pdo->prepare("INSERT INTO students (fullname, matric_no) VALUES (?, ?)");
if($stmt->execute([$fullname, $matric])) {
    header('Location: ../vote/index.php?matric_no=' . urlencode($matric));
} else {
    echo "Registration failed or duplicate matric number.";
}
?>