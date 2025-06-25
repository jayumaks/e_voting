<?php
include('../dbcon.php');

$poll = $pdo->query("SELECT * FROM poll LIMIT 1")->fetch();
if (!$poll) {
    die("No poll found.");
}

$options = $pdo->prepare("SELECT * FROM options WHERE poll_id = ?");
$options->execute([$poll['id']]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Poll Results</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #f9f9f9;
        }

        header {
            background-color: #000;
            color: #fff;
            padding: 20px 15px;
            text-align: center;
        }

        header img {
            height: 50px;
            vertical-align: middle;
        }

        header span {
            font-size: 22px;
            font-weight: bold;
            vertical-align: middle;
            margin-left: 10px;
        }

        .container {
            max-width: 700px;
            margin: 40px auto;
            background: #fff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        .result-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #f0f0f0;
            margin: 10px 0;
            padding: 12px 20px;
            border-radius: 6px;
            font-size: 16px;
        }

        footer {
            text-align: center;
            background-color: #222;
            color: white;
            padding: 15px;
            position: fixed;
            width: 100%;
            bottom: 0;
        }

        @media (max-width: 600px) {
            .container {
                margin: 20px;
                padding: 20px;
            }

            .result-item {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>

<header>
    <img src="../assets/logo.png" alt="Logo">
    <span>AAU Voting System</span>
</header>

<div class="container">
    <h2>Poll Results: <?= htmlspecialchars($poll['question']) ?></h2>
    <?php foreach($options as $opt): ?>
        <div class="result-item">
            <strong><?= htmlspecialchars($opt['option_text']) ?></strong>
            <span><?= $opt['votes'] ?> votes</span>
        </div>
    <?php endforeach; ?>
</div>

<footer>
    &copy; <?= date('Y') ?> Ambrose Alli University Voting System
</footer>

</body>
</html>
