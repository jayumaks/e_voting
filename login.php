<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>


<?php
session_start();
require_once './admin/dbcon.php';

// Handle login BEFORE HTML
if (isset($_POST['login'])) {
    $idno = trim($_POST['idno']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM voters WHERE id_number = ?");
    $stmt->bind_param("s", $idno);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            if (strtolower($user['account']) !== 'active') {
                $error = "Your account is not activated.";
            } elseif (strtolower($user['status']) === 'voted') {
                $error = "Sorry, you have already voted.";
            } else {
                $_SESSION['voters_id'] = $user['voters_id'];
                header("Location: vote.php");
                exit();
            }
        } else {
            $error = "Invalid ID number or password.";
        }
    } else {
        $error = "Invalid ID number or password.";
    }
}
?>

<?php include ('head.php'); ?>
<body>
  <?php include ('view_banner.php'); ?>

  <div class="login-container">
    <div class="login-panel">
      <form method="POST">
        <div class="form-heading text-center">Student Login</div>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger text-center"><?= $error ?></div>
        <?php endif; ?>

        <div class="form-field">
          <label for="idno">Student ID:</label>
          <input class="form-control" name="idno" type="text" required autofocus>
        </div>

        <div class="form-field">
          <label for="password">Password:</label>
          <input class="form-control" name="password" type="password" required>
        </div>

        <button class="btn btn-success btn-block" name="login">Login</button>
        <a href="register/index.php" class="btn btn-success btn-block">Register</a>
      </form>
    </div>
  </div>

  <?php include ('script.php'); ?>
</body>
</html>
