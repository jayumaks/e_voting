<!-- sidebar.php -->
<nav class="navbar navbar-inverse sidebar" role="navigation" style="background-color: black; border: none;">
  <div class="container-fluid">
    
    <!-- Sidebar Header with Hamburger and Brand -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#sidebar-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php" style="color: white; font-weight: bold;">
        <i class="fa fa-home"></i> AAU Voting System
      </a>
    </div>

    <!-- Collapsible Sidebar Content -->
    <div class="collapse navbar-collapse" id="sidebar-collapse">
      <ul class="nav navbar-nav">
         <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" style = "color: white">
					<i>Welcome: <?php echo $user_username = $user_row['firstname']." ".$user_row['lastname'];?></i>
                    </a>                     
                </li>
        <li><a href="results.php" style="color: white;"><i class="fa fa-line-chart"></i> Results</a></li>
        <li><a href="logout.php" style="color: white;"><i class="fa fa-sign-out"></i> Logout</a></li>
      </ul>
    </div>

  </div>
</nav>

<!-- Optional Sidebar Styling -->
<style>
  .sidebar {
    min-height: 50vh;
    padding-top: 20px;
  }

  .sidebar .nav > li > a {
    padding: 12px 20px;
    display: block;
    font-size: 16px;
    color: #ccc;
  }

  .sidebar .nav > li > a:hover {
    background-color: #111;
    color: #fff;
  }

  @media (max-width: 768px) {
    .sidebar {
      position: relative;
      width: 100%;
    }
  }
</style>
