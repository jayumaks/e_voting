<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'admin/dbcon.php';

if (isset($_POST['login'])) {
    $idno = trim($_POST['idno']);
    $password = $_POST['password'];

    // Prepare and execute query to fetch user by ID number
    $stmt = $conn->prepare("SELECT * FROM voters WHERE id_number = ?");
    $stmt->bind_param("s", $idno);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify password using password_verify if hashed
        if (password_verify($password, $user['password'])) {

            // Check account status
            if (strtolower($user['account']) !== 'active') {
                $_SESSION['error'] = "Your account is not activated.";
            } elseif (strtolower($user['status']) === 'voted') {
                $_SESSION['error'] = "Sorry, you have already voted.";
            } else {
                // Successful login
                $_SESSION['voters_id'] = $user['voters_id'];
                header("Location: vote.php");
                exit();
            }

        } else {
            $_SESSION['error'] = "Invalid ID number or password.";
        }

    } else {
        $_SESSION['error'] = "Invalid ID number or password.";
    }

    $stmt->close();
}
?>
