<?php
include('../dbcon.php');
session_start();

if (!isset($_SESSION['poll_voter_id'])) {
    die("Unauthorized access. Please <a href='../login.php'>login</a>.");
}

$voter_id = $_SESSION['poll_voter_id'];

$stmt = $pdo->prepare("SELECT * FROM voters WHERE voters_id = ?");
$stmt->execute([$voter_id]);
$user = $stmt->fetch();

if (!$user) die("Voter not found.");
if ($user['voted']) die("You have already voted.");

$poll = $pdo->query("SELECT * FROM poll LIMIT 1")->fetch();
$options = $pdo->prepare("SELECT * FROM options WHERE poll_id = ?");
$options->execute([$poll['id']]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vote - AAU Opinion Poll</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: #f4f6f8;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #003366;
            color: white;
            padding: 10px 20px;
        }

        .header img {
            height: 40px;
        }

        .header nav a {
            color: white;
            margin-left: 20px;
            text-decoration: none;
            font-weight: bold;
        }

        .container {
            max-width: 700px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            margin-top: 30px;
        }

        .option {
            padding: 15px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background: #fafafa;
            display: flex;
            align-items: center;
            transition: background 0.3s;
        }

        .option:hover {
            background: #f0f0f0;
        }

        .option input[type="radio"] {
            margin-right: 15px;
        }

        button {
            display: block;
            width: 100%;
            padding: 15px;
            background: #0066cc;
            color: white;
            border: none;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
        }

        button:hover {
            background: #004c99;
        }

        @media (max-width: 600px) {
            .header {
                flex-direction: column;
                text-align: center;
            }

            .header nav {
                margin-top: 10px;
            }
        }
    </style>
</head>
<body>

<!-- Header -->
<div class="header">
    <img src="../assets/logo.png" alt="AAU Logo"> <!-- Replace with actual path to logo -->
    <nav>
        <a href="..//index.php">Home</a>
        <a href="../results.php">Results</a>
        <a href="../logout.php">Logout</a>
    </nav>
</div>

<!-- Voting Form -->
<div class="container">
    <h2><?= htmlspecialchars($poll['question']) ?></h2>
    <form method="POST" action="process.php">
        <?php foreach ($options as $opt): ?>
            <label class="option">
                <input type="radio" name="option_id" value="<?= $opt['id'] ?>" required>
                <?= htmlspecialchars($opt['option_text']) ?>
            </label>
        <?php endforeach; ?>

        <input type="hidden" name="voter_id" value="<?= $voter_id ?>">
        <button type="submit">✅ Submit My Vote</button>
    </form>
</div>

</body>
</html>
