<?php 
session_start();
ob_start();

include ('head.php'); ?>
<body>
  <?php include ('view_banner.php'); ?>

  <style>
    /* .login-container {
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 20px 20px; /* More top space */
} */
.login-container {
  flex: 1;
  display: flex;
  align-items: flex-start;
  justify-content: center;
  margin-top: 40px; /* adjust as needed */
  padding: 0 20px;
}


    .login-panel {
      background: #ffffff;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      padding: 20px;
      width: 100%;
      max-width: 400px;
    }

    .form-heading {
      font-size: 24px;
      font-weight: bold;
      margin-bottom: 20px;
      color: #003366;
    }

    .form-field {
      margin-bottom: 20px;
    }

    .form-panel select {
      padding: 10px;
      border-radius: 5px;
      border: 1px solid #ccc;
      width: 100%;
      margin-top: 10px;
    }

    .btn-success {
      background-color: #003366;
      border-color: #003366;
      color: white;
    }

    .btn-success:hover {
      background-color: #0055aa;
      border-color: #0055aa;
    }
    .btn-block {
  width: 100%;
  margin-bottom: 10px;
}


    @media (max-width: 500px) {
      .login-panel {
        padding: 20px;
      }
      .form-heading {
        font-size: 20px;
      }
    }
  </style>

 <div class="login-container">
  <div class="login-panel">
    <div class="form-panel">
      <div style="text-align: center;">
        <label style="font-style: italic;">Login As:</label>
        <select onchange="page(this.value)">
          <option value="admin/index.php">System Admin</option>
          <option value="admin2/index.php">System User</option>
          <option selected disabled>Student Voter</option>
        </select>
      </div>

      <form role="form" method="post" enctype="multipart/form-data" class="index-form">
        <div class="form-heading text-center">Student Login</div>

        <div class="form-field">
          <label for="idno">Student ID:</label>
          <input class="form-control" placeholder="Enter Student ID" name="idno" type="text" required autofocus>
        </div>

        <div class="form-field">
          <label for="password">Password:</label>
          <input class="form-control" placeholder="Enter Password" name="password" type="password" required>
        </div>

        <div style="text-align: center;">
          <button class="btn btn-lg btn-success btn-block" name="login">Login</button>
          <a href="register/index.php" class="btn btn-lg btn-success btn-block" style="margin-top: 10px;">Register</a>
        </div>

        <?php include('login_query.php'); ?>
      </form>
    </div>
  </div>
</div>


  <?php include ('script.php'); ?>

  <script type="text/javascript">
    function page(src) {
      window.location = src;
    }
  </script>

  <?php include ('footer.php'); ?>
</body>
</html>
