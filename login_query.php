<?php
require_once 'admin/dbcon.php';

if (isset($_POST['login'])) {
    $idno = trim($_POST['idno']);
    $password = $_POST['password'];

    // Prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM voters WHERE id_number = ?");
    $stmt->bind_param("s", $idno);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Check password using password_verify
        if (password_verify($password, $user['password'])) {

            if (strtolower($user['account']) !== 'active') {
                echo "<script>alert('Your account is not activated');</script>";
            } elseif (strtolower($user['status']) === 'voted') {
                echo "<script>alert('Sorry, you have already voted');</script>";
            } else {
                $_SESSION['voters_id'] = $user['voters_id'];
                header('Location: vote.php');
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
