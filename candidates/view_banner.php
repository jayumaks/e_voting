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

<!-- Responsive Navigation Bar -->
<div class="side-bar">
  <!-- Logo on the left -->
  <div>
    <img src="../img/logo.png" alt="Logo">
  </div>

  <!-- Title in the center -->
  <div class="site-title">2025 Student Union Candidates</div>

  <!-- Hamburger for mobile -->
  <div class="hamburger" onclick="toggleMenu()">
    <div></div>
    <div></div>
    <div></div>
  </div>

  <!-- Navigation menu -->
  <nav class="nav-menue" id="navMenu">
    <ul>
      <li><a href="../index.php">Home</a></li>
      <li><a href="../view.php">Candidates</a></li>
      <li><a href="../register/index.php">Register</a></li>
      <li><a href="../voters.php">Voter List</a></li>
    </ul>
  </nav>
</div>

<!-- Hamburger Script -->
<script>
  function toggleMenu() {
    document.getElementById('navMenu').classList.toggle('active');
  }
</script>
