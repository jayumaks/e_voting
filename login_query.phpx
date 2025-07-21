<?php
session_start();
require_once 'admin/dbcon.php';

if (isset($_POST['login'])) {
    $idno = trim($_POST['idno']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT voters_id, password, account, status FROM voters WHERE id_number = ?");
    if (!$stmt) {
        echo "<script>alert('Database error: prepare failed');</script>";
        exit();
    }

    $stmt->bind_param("s", $idno);
    $stmt->execute();
    $stmt->store_result();

    // Bind the result variables
    $stmt->bind_result($voters_id, $hashed_password, $account, $status);

    if ($stmt->fetch()) {
        if (password_verify($password, $hashed_password)) {
            if (strtolower($account) !== 'active') {
                echo "<script>alert('Your account is not activated');</script>";
            } elseif (strtolower($status) === 'voted') {
                echo "<script>alert('Sorry, you have already voted');</script>";
            } else {
                $_SESSION['voters_id'] = $voters_id;
                header("Location: vote.php");
                exit();
            }
        } else {
            echo "<script>alert('Invalid ID number or password');</script>";
        }
    } else {
        echo "<script>alert('Invalid ID number or password');</script>";
    }

    $stmt->close();
}
?>
