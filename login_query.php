<?php
require_once 'admin/dbcon.php';

if (isset($_POST['login'])) {
    $idno = $_POST['idno'];
    $password = md5($_POST['password']);

    // First, check if user exists
    $userCheck = $conn->query("SELECT * FROM voters WHERE id_number = '$idno' AND password = '$password'") or die(mysqli_error($conn));

    if ($userCheck->num_rows > 0) {
        $user = $userCheck->fetch_assoc();

        if (strtolower($user['account']) != 'active') {
            echo "<script>alert('Your account is not activated');</script>";
        } elseif (strtolower($user['status']) == 'voted') {
            echo "<script>alert('Sorry, you have already voted');</script>";
        } else {
            // Successful login
            $_SESSION['voters_id'] = $user['voters_id'];
            header('location:vote.php');
            exit();
        }
    } else {
        // No user found with those credentials
        echo "<script>alert('Invalid ID number or password');</script>";
    }
}
?>
