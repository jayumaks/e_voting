<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom:0; background-color:#0022ff;">
    <div class="navbar-header">
        <!-- Mobile Hamburger Toggle -->
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#mobile-sidebar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar" style="background:white;"></span>
            <span class="icon-bar" style="background:white;"></span>
            <span class="icon-bar" style="background:white;"></span>
        </button>
        <a class="navbar-brand" href="../index.php" style="color:white;">
            <i class="fa fa-home"></i> HOME | Admin Portal
        </a>
    </div>

    <!-- Top Right User Info -->
    <ul class="nav navbar-top-links navbar-right">
        <?php
        require 'dbcon.php';
        $query = $conn->query("SELECT * FROM user WHERE user_id ='$session_id'") or die($conn->error);
        while ($user_row = $query->fetch_array()) {
        ?>
        <li>
            <a style="color:white;">
                <i>Welcome: <?php echo $user_row['firstname'] . " " . $user_row['lastname']; ?></i>
            </a>
        </li>
        <?php } ?>
    </ul>

    <!-- Sidebar for desktop -->
    <div class="navbar-default sidebar hidden-xs" role="navigation" style="background-color:#f8f8f8;">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li><a href="candidate.php"><i class="fa fa-user fa-fw"></i> View Candidates</a></li>
                <li><a href="voters.php"><i class="fa fa-user fa-fw"></i> View Voters</a></li>
                <li><a href="current_students.php"><i class="fa fa-user fa-fw"></i> Students</a></li>
                <li><a href="canvassing.php"><i class="fa fa-download fa-fw"></i> Election Reports</a></li>
                <li><a href="user.php"><i class="fa fa-users"></i> View User</a></li>
                <li><a href="login_times.php"><i class="fa fa-clock-o"></i> User Login Time</a></li>
                <li><a href="logout.php"><i class="fa fa-sign-out"></i> Logout</a></li>
            </ul>
        </div>
    </div>

    <!-- Sidebar for mobile -->
    <div id="mobile-sidebar" class="collapse visible-xs" style="background-color:#f8f8f8;">
        <ul class="nav" style="padding: 10px;">
            <li><a href="candidate.php"><i class="fa fa-user fa-fw"></i> View Candidates</a></li>
            <li><a href="voters.php"><i class="fa fa-user fa-fw"></i> View Voters</a></li>
            <li><a href="current_students.php"><i class="fa fa-user fa-fw"></i> Students</a></li>
            <li><a href="canvassing.php"><i class="fa fa-download fa-fw"></i> Election Reports</a></li>
            <li><a href="user.php"><i class="fa fa-users"></i> View User</a></li>
            <li><a href="login_times.php"><i class="fa fa-clock-o"></i> User Login Time</a></li>
            <li><a href="logout.php"><i class="fa fa-sign-out"></i> Logout</a></li>
        </ul>
    </div>
</nav>
