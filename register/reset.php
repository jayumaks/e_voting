<?php
session_start();
unset($_SESSION['otp']);
unset($_SESSION['otp_verified']);
unset($_SESSION['email']);
unset($_SESSION['masked_email']);
unset($_SESSION['id_number']);
unset($_SESSION['error']);
unset($_SESSION['success']);

header("Location: index.php");
exit();
