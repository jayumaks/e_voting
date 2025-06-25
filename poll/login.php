<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include('dbcon.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id_number'];
    $pass = md5($_POST['password']);

    $stmt = $pdo->prepare("SELECT * FROM voters WHERE id_number = ? AND password = ? AND status = 'Active'");
    $stmt->execute([$id, $pass]);
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION['voter_id'] = $user['voters_id'];
        header("Location: vote.php?matric_no={$id}");
        exit;
    } else {
        echo "<script>alert('Invalid credentials or account not activated'); window.location='index.php';</script>";
        exit;
    }
}
?>