
<!-- <div class="side-bar" 
            style="background-color:rgba(0, 100, 0, 1); font-size:25px; text-align:center; margin-top:-10px; padding-top:20px; padding-bottom:0px;">

                <a href="#" style="color:white; font-weight:bold; font-size:30px;">Collage Online Voting System.</a>
                </a>

        <nav class="nav-menue">
            <ul>
                <li>
                    <a href="../index.php">Home</a>
                </li>
                <li><a href="../candidate_path.php">Candidates</a></li>
                
                <li><a href="../voters.php">Voter List</a></li>
            </ul>
        </nav>
    </div>
					
</div> -->


<style>
  .side-bar {
    background-color: rgba(0, 00, 0, 1);
    padding: 15px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
  }

  .side-bar img {
    height: 60px;
  }

  .site-title {
    color: white;
    font-weight: bold;
    font-size: 26px;
    flex-grow: 1;
    text-align: center;
  }

  .nav-menue ul {
    list-style: none;
    padding: 0;
    margin: 0;
  }

  .nav-menue ul li {
    display: inline-block;
    margin-left: 20px;
  }

  .nav-menue ul li a {
    color: white;
    text-decoration: none;
    font-weight: bold;
  }

  .nav-menue ul li a:hover {
    text-decoration: underline;
  }

  .hamburger {
    display: none;
    flex-direction: column;
    cursor: pointer;
  }

  .hamburger div {
    width: 25px;
    height: 3px;
    background-color: white;
    margin: 4px 0;
  }

  @media (max-width: 768px) {
    .site-title {
      width: 100%;
      text-align: center;
      margin: 10px 0;
    }

    .hamburger {
      display: flex;
    }

    .nav-menue {
      display: none;
      width: 100%;
      text-align: center;
    }

    .nav-menue.active {
      display: block;
    }

    .nav-menue ul li {
      display: block;
      margin: 10px 0;
    }
  }
</style>

<div class="side-bar">
  <!-- Logo -->
  <div>
    <a href="index.php">
    <img src="../img/logo.png" alt="Logo">
    </a>
  </div>

  <!-- Title -->
  <div class="site-title">AAU Online Voting System</div>

  <!-- Hamburger icon -->
  <div class="hamburger" onclick="toggleMenu()">
    <div></div>
    <div></div>
    <div></div>
  </div>

  <!-- Navigation -->
  <nav class="nav-menue" id="navMenu">
    <ul>
      <li><a href="../index.php">Home</a></li>
      <li><a href="../candidate_path.php">Candidates</a></li>
      
      <li><a href="../voters.php">Voter List</a></li>
    </ul>
  </nav>
</div>

<script>
  function toggleMenu() {
    document.getElementById("navMenu").classList.toggle("active");
  }
</script>