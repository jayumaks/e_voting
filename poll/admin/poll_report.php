<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include('../dbcon.php');

// Fetch latest poll
$poll = $pdo->query("SELECT * FROM poll ORDER BY id DESC LIMIT 1")->fetch();

if (!$poll) {
    die("No poll found.");
}

$options = $pdo->prepare("SELECT option_text, votes FROM options WHERE poll_id = ?");
$options->execute([$poll['id']]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Live Poll Results</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: "Segoe UI", sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        .header {
            background-color: #003366;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .container {
            max-width: 600px;
            margin: 30px auto;
            background: white;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.08);
        }

        h2 {
            text-align: center;
            color: #003366;
        }

        .option {
            background: #f0f0f0;
            padding: 12px 16px;
            border-radius: 6px;
            margin: 10px 0;
            display: flex;
            justify-content: space-between;
            font-size: 16px;
        }

        .back-btn {
            display: block;
            text-align: center;
            margin-top: 20px;
            background: #003366;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
        }

        .back-btn:hover {
            background-color: #0055aa;
        }

        @media (max-width: 600px) {
            .container {
                margin: 20px;
                padding: 20px;
            }

            .option {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>AAU Voting System</h1>
    </div>

    <div class="container">
        <h2>Live Results: <?= htmlspecialchars($poll['question']) ?></h2>
        <?php while ($option = $options->fetch()): ?>
            <div class="option">
                <span><?= htmlspecialchars($option['option_text']) ?></span>
                <strong><?= $option['votes'] ?> votes</strong>
            </div>
        <?php endwhile; ?>

        <a class="back-btn" href="../index.php">⬅ Back to Home</a>
    </div>

</body>
</html>
