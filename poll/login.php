<?php
session_start();
include('dbcon.php');

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'];
    $password = md5($_POST['password']); // Ensure it matches your DB hashing

    $stmt = $pdo->prepare("SELECT * FROM voters WHERE id_number = ? AND password = ? AND account = 'active'");
    $stmt->execute([$student_id, $password]);

    if ($stmt->rowCount() > 0) {
        $voter = $stmt->fetch();
        $_SESSION['poll_voter_id'] = $voter['voters_id'];

        // Set cookie if "Remember me" is checked
        if (isset($_POST['remember'])) {
            setcookie('student_id', $student_id, time() + (86400 * 30), "/");
        }

        header("Location: vote/index.php");
        exit;
    } else {
        $error = "Invalid Student ID, password, or account not active.";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Poll Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/style.css">
    <style>
        /* Full-page layout with flex */
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

        /* Sticky header */
        .header {
            background: black;
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

        /* Main content grows to fill space */
        main.container {
            flex: 1;
            max-width: 400px;
            margin: 40px auto;
            padding: 30px;
            background: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        /* Footer sticks to bottom */
        .footer {
            background: #333;
            color: white;
            text-align: center;
            padding: 15px;
        }


        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f4f4;
            margin: 0;
        }

        header {
            background: black;
            color: white;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo img {
            height: 40px;
            margin-right: 10px;
        }

        nav a {
            color: white;
            margin-left: 15px;
            text-decoration: none;
            font-weight: bold;
        }

        .container {
            max-width: 400px;
            background: white;
            padding: 30px;
            margin: 60px auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #003366;
            color: white;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background-color: #002244;
        }

        .footer {
            background: #333;
            color: white;
            text-align: center;
            padding: 15px;
            margin-top: 60px;
        }

        .remember-show {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        @media (max-width: 500px) {
            header {
                flex-direction: column;
                align-items: flex-start;
            }

            nav {
                margin-top: 10px;
            }
        }
    </style>
</head>

<body>
    <div class="page-wrapper">
        <!-- Header -->
        <header class="header">
            <div class="logo">
                <img src="assets/logo.png" alt="Logo">
                <span>AAU Online Voting</span>
            </div>
            <nav>
                <a href="../index.php">Home</a>
                <a href="../register/index.php">Register</a>
                <a href="admin/login.php">Admin</a>
            </nav>
        </header>

        <!-- Main content -->
        <main class="container">
            <h2 style="text-align:center;">Login to Vote</h2>

            <?php if (!empty($error)): ?>
                <p style="color:red;"><?php echo $error; ?></p>
            <?php endif; ?>

            <form method="post" action="login.php">
                <label>Student ID</label>
                <input type="text" name="student_id" value="<?= $_COOKIE['student_id'] ?? '' ?>" required>

                <label>Password</label>
                <input type="password" name="password" id="password" required>

                <div class="remember-show">
                    <label><input type="checkbox" onclick="togglePassword()"> Show Password</label>
                    <label><input type="checkbox" name="remember"> Remember me</label>
                </div>

                <br>
                <button type="submit">Login</button>
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
            var pass = document.getElementById("password");
            pass.type = pass.type === "password" ? "text" : "password";
        }
    </script>
</body>

</html>