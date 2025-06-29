<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include('dbcon.php');

// Fetch latest poll
$poll = $pdo->query("SELECT * FROM poll ORDER BY id DESC LIMIT 1")->fetch();
if (!$poll) die("No poll found.");

// Fetch poll options
$options = $pdo->prepare("SELECT option_text, votes FROM options WHERE poll_id = ?");
$options->execute([$poll['id']]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Live Poll Results</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f6f9;
            color: #333;
        }
        .header {
            background-color: #003366;
            color: white;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
        }
        .header img {
            height: 45px;
        }
        .site-title {
            flex: 1;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
        }
        .nav-link {
            color: white;
            text-decoration: none;
            font-weight: bold;
            margin-left: auto;
        }
        .container {
            max-width: 800px;
            margin: 30px auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }
        h2 {
            text-align: center;
            color: #003366;
            margin-bottom: 25px;
        }
        ul {
            list-style: none;
            padding-left: 0;
        }
        li {
            background-color: #e6f0ff;
            padding: 12px 16px;
            margin: 10px 0;
            border-radius: 4px;
            font-size: 16px;
        }
        a.button {
            display: block;
            width: fit-content;
            margin: 30px auto 0;
            text-decoration: none;
            background-color: #003366;
            color: white;
            padding: 10px 25px;
            border-radius: 4px;
            text-align: center;
        }
        .footer {
            text-align: center;
            background-color: #003366;
            color: white;
            padding: 15px 10px;
            margin-top: 40px;
            font-size: 14px;
        }

        @media screen and (max-width: 600px) {
            .header {
                flex-direction: column;
                text-align: center;
            }
            .site-title {
                margin-top: 10px;
                font-size: 18px;
            }
            .nav-link {
                margin: 10px 0;
            }
        }
    </style>
</head>
<body>

<div class="header">
    <a href="../index.php"><img src="../img/logo.png" alt="Logo"></a>
    <div class="site-title">AAU Online Voting System - Live Results</div>
    <a class="nav-link" href="../index.php">Home</a>
</div>

<div class="container">
    <h2><?= htmlspecialchars($poll['question']); ?></h2>
    <ul>
        <?php while ($option = $options->fetch()): ?>
            <li><?= htmlspecialchars($option['option_text']) ?> — <?= $option['votes'] ?> votes</li>
        <?php endwhile; ?>
    </ul>
    <a class="button" href="../index.php">⬅ Back to Home</a>
</div>

<div class="footer">
    &copy; <?= date("Y") ?> WDM. ICT, AAU. All rights reserved.
</div>

</body>
</html>
