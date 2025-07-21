<?php
if (!isset($_SESSION)) {
    session_start(); // Start session if not already started
}

require 'admin/dbcon.php';

// Check if voter is logged in
if (!isset($_SESSION['voters_id'])) {
    header("Location: login.php");
    exit();
}

$session_id = $_SESSION['voters_id'];
$query = $conn->query("SELECT * FROM voters WHERE voters_id = '$session_id'") or die(mysqli_error($conn));
$row = $query->fetch_assoc(); // only one user expected
?>

<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom:0; background-color:black;">
    <div class="navbar-header">
        <a class="navbar-brand" href="index.php" style="color:white; padding-left:25px;">
            <i class="fa fa-home fa-large"></i> HOME | AAU Online Voting System
        </a>
    </div>

    <ul class="nav navbar-top-links navbar-right">
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#" style="color: white">
                <i>Welcome: <?php echo $row['firstname'] . " " . $row['lastname']; ?></i>
            </a>
        </li>
        <li class="dropdown">
            <a href="logout.php" style="color: white; padding-right: 30px;">
                <i class="fa fa-sign-out" style="color: white"></i> Logout
            </a>
        </li>
    </ul>
</nav>
