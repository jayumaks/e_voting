<?php
session_start();
require_once 'admin/dbcon.php';

$login_error = '';

if (isset($_POST['login'])) {
  $idno = trim($_POST['idno']);
  $password = $_POST['password'];

  $stmt = $conn->prepare("SELECT voters_id, password, account, status FROM voters WHERE id_number = ?");
  if ($stmt) {
    $stmt->bind_param("s", $idno);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($voters_id, $hashed_password, $account, $status);

    if ($stmt->fetch()) {
      if (password_verify($password, $hashed_password)) {
        if (strtolower($account) !== 'active') {
          $login_error = "Your account is not activated.";
        } elseif (strtolower($status) === 'voted') {
          $login_error = "Sorry, you have already voted.";
        } else {
          $_SESSION['voters_id'] = $voters_id;
          header("Location: vote.php");
          exit();
        }
      } else {
        $login_error = "Invalid ID number or password.";
      }
    } else {
      $login_error = "Invalid ID number or password.";
    }

    $stmt->close();
  } else {
    $login_error = "Database error: Unable to prepare statement.";
  }
}
?>

<!DOCTYPE html>
<html>
<?php include('head.php'); ?>

<body>
  <?php include('view_banner.php'); ?>

  <style>
    .login-container {
      display: flex;
      align-items: center;
      justify-content: center;
      margin-top: 40px;
      padding: 20px;
    }

    .login-panel {
      background: #ffffff;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      padding: 20px;
      max-width: 400px;
      width: 100%;
    }

    .form-heading {
      font-size: 24px;
      font-weight: bold;
      margin-bottom: 20px;
      color: #003366;
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

        <form method="post" class="index-form">
          <div class="form-heading text-center">Student Login</div>

          <?php if (!empty($login_error)): ?>
            <div class="alert alert-danger text-center"><?= $login_error; ?></div>
          <?php endif; ?>

          <div class="form-group">
            <label for="idno">Student ID:</label>
            <input class="form-control" name="idno" type="text" required autofocus placeholder="Enter Student ID">
          </div>

          <div class="form-group">
            <label for="password">Password:</label>
            <input class="form-control" name="password" id="password" type="password" required placeholder="Enter Password">
          </div>

          <div class="form-check mb-3">
            <input type="checkbox" class="form-check-input" id="showPassword" onclick="togglePassword()">
            <label class="form-check-label" for="showPassword">Show Password</label>
          </div>

          <script>
            function togglePassword() {
              const pwd = document.getElementById("password");
              pwd.type = pwd.type === "password" ? "text" : "password";
            }
          </script>


          <div style="text-align: center;">
            <button class="btn btn-lg btn-success btn-block" name="login">Login</button>
            <a href="register/index.php" class="btn btn-lg btn-success btn-block" style="margin-top: 10px;">Register</a>
          </div>
        </form>
      </div>
    </div>
  </div>

  <?php include('script.php'); ?>

  <script>
    function page(src) {
      window.location = src;
    }
  </script>

  <?php include('footer.php'); ?>
</body>

</html>