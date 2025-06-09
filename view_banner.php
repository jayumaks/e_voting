<style type="text/css">
/* Header container */
.header-bar {
  background-color: rgba(0, 00, 0, 1);
  padding: 10px 20px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 10px;
}

/* Logo */
.logo {
  height: 60px;
}

/* Title */
.site-title {
  color: white;
  font-weight: bold;
  font-size: 30px;
  text-align: center;
  flex: 1;
}

/* Nav menu */
.nav-menue {
  display: none;
  width: 100%;
  text-align: center;
}

.nav-menue.active {
  display: block;
}

.nav-menue ul {
  list-style: none;
  padding: 0;
  margin: 0;
}

.nav-menue ul li {
  display: inline-block;
  padding: 10px 20px;
}

.nav-menue ul li a {
  color: white;
  font-weight: bold;
  font-size: 16px;
  text-decoration: none;
}

.nav-menue ul li a:hover {
  text-decoration: underline;
}

/* Hamburger */
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

/* Mobile styles */
@media (max-width: 768px) {
  .site-title {
    order: 1;
    width: 100%;
    margin: 10px 0;
  }
  .hamburger {
    display: flex;
  }
  .nav-menue ul li {
    display: block;
  }
}

/* Desktop styles */
@media (min-width: 769px) {
  .nav-menue {
    display: block !important;
    width: auto;
  }
  .header-bar {
    justify-content: space-between;
  }
}


</style>

<!-- Header Container -->
<div class="header-bar">
    <!-- Logo on the far left -->
   <div>
  <a href="index.php">
    <img src="img/logo.png" alt="Logo" class="logo">
  </a>
</div>


    <!-- Title centered -->
    <div class="site-title">Student Union Elections 2025</div>

    <!-- Hamburger icon -->
    <div class="hamburger" onclick="toggleMenu()">
        <div></div>
        <div></div>
        <div></div>
    </div>

    <!-- Nav on the far right -->
    <nav class="nav-menue" id="navMenu">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="candidate_path.php">Candidates</a></li>
            <li><a href="register/index.php">Register</a></li>
            <li><a href="voters.php">Voter List</a></li>
            <li><a href="login.php">Login</a></li>
        </ul>
    </nav>
</div>

<script>
function toggleMenu() {
    document.getElementById("navMenu").classList.toggle("active");
}
</script>
