<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Login - AAU Voting System</title>
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        body,
        html {
            margin: 0;
            padding: 0;
            height: 100%;
        }

        .page-wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .header {
            background: #003366;
            color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header .logo {
            display: flex;
            align-items: center;
        }

        .header .logo img {
            height: 40px;
            margin-right: 10px;
        }

        .header nav a {
            color: white;
            margin-left: 15px;
            text-decoration: none;
            font-weight: bold;
        }

        main.container {
            flex: 1;
            max-width: 400px;
            margin: 40px auto;
            padding: 30px;
            background: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .footer {
            background: #333;
            color: white;
            text-align: center;
            padding: 15px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
        }

        button {
            width: 100%;
            padding: 10px;
            background: black;
            color: white;
            border: none;
            border-radius: 5px;
        }

        .remember-show {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="page-wrapper">
        <!-- Header -->
        <header class="header">
            <div class="logo">
                <img src="../assets/logo.png" alt="AAU Logo">
                <span>AAU Voting System</span>
            </div>
            <nav>
                <a href="https://voting.aauekpoma.edu.ng/index.php">Home</a>
                <a href="https://voting.aauekpoma.edu.ng/poll/results.php">Poll</a>
                <a href="https://voting.aauekpoma.edu.ng/register/index.php">Register</a>
            </nav>
        </header>

        <!-- Main Content -->
        <main class="container">
            <h2 style="text-align:center;">Admin Login</h2>

            <?php if (!empty($_SESSION['error'])): ?>
                <p style="color:red;"><?php echo $_SESSION['error'];
                                        unset($_SESSION['error']); ?></p>
            <?php endif; ?>

            <form method="POST" action="auth.php">
                <label>Username</label>
                <input type="text" name="username" required>

                <label>Password</label>
                <input type="password" name="password" id="admin-password" required>

                <div class="remember-show">
                    <label><input type="checkbox" onclick="togglePassword()"> Show Password</label>
                    <label><input type="checkbox" name="remember"> Remember me</label>
                </div>

                <br><button type="submit">Login</button>
            </form>
        </main>

        <!-- Footer -->
        <footer class="footer">
            &copy;<?= date('Y') ?> Developed by WDM, ICT, AAU<br />
            AAU E-VOTING SYSTEM<br />
            Email: <a href="mailto:webmaster@aauekpoma.edu.ng">webmaster@aauekpoma.edu.ng</a>
        </footer>
    </div>

    <script>
        function togglePassword() {
            var x = document.getElementById("admin-password");
            x.type = x.type === "password" ? "text" : "password";
        }
    </script>
</body>

</html>