<?php session_start(); ?>
<?php include('../header.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        .login-box {
            max-width: 400px;
            margin: 60px auto;
            padding: 30px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
            text-align: center;
        }
        .login-box input[type="text"],
        .login-box input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .login-box button {
            width: 100%;
            padding: 12px;
            background: #003366;
            color: white;
            border: none;
            border-radius: 5px;
            font-weight: bold;
        }
        .login-box button:hover {
            background: #0055aa;
        }
        .form-footer {
            margin-top: 15px;
            font-size: 14px;
        }
        .form-footer label {
            display: inline-block;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="login-box">
        <h2>Admin Login</h2>

        <?php if (!empty($_SESSION['error'])): ?>
            <p style="color: red;"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
        <?php endif; ?>

        <form method="POST" action="auth.php">
            <input type="text" name="username" placeholder="Username" required>

            <input type="password" name="password" id="password" placeholder="Password" required>

            <div class="form-footer">
                <input type="checkbox" onclick="togglePassword()"> Show Password
                <br><br>
                <label>
                    <input type="checkbox" name="remember"> Remember Me
                </label>
            </div>

            <button type="submit">Login</button>
        </form>

        <div class="form-footer">
            <p><a href="#">Forgot Password?</a> (optional)</p>
        </div>
    </div>
</div>

<script>
function togglePassword() {
    var pass = document.getElementById("password");
    pass.type = (pass.type === "password") ? "text" : "password";
}
</script>

<?php include('../footer.php'); ?>
</body>
</html>
