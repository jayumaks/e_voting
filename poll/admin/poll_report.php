<?php
ini_set('session.cookie_samesite', 'Lax');  // ensures mobile and cross-page persistence


session_start();
include('../dbcon.php');
if (!isset($_SESSION['admin'])) { header('Location: login.php'); exit; }

// Handle reset
if (isset($_POST['reset_votes'])) {
    $pdo->exec("UPDATE options SET votes = 0");
    $pdo->exec("UPDATE voters SET voted = 0");
    $message = "✅ All votes have been reset successfully.";
}

$poll = $pdo->query("SELECT * FROM poll LIMIT 1")->fetch();
$options = $pdo->prepare("SELECT * FROM options WHERE poll_id = ?");
$options->execute([$poll['id']]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Poll Report</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f6f8;
        }
        .header, .footer {
            background-color: #003366;
            color: white;
            padding: 15px 20px;
            text-align: center;
        }
        .container {
            max-width: 800px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
        }
        ul {
            list-style-type: none;
            padding-left: 0;
        }
        ul li {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        .message {
            padding: 10px;
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .btn {
            padding: 12px 25px;
            background-color: #c0392b;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #a93226;
        }
        @media (max-width: 600px) {
            .container {
                margin: 20px;
                padding: 20px;
            }
        }
    </style>
</head>
<body>

<!-- Header -->
<div class="header">
    <h1>AAU Voting Admin</h1>
</div>

<!-- Content -->
<div class="container">
    <?php if (!empty($message)): ?>
        <div class="message"><?= $message ?></div>
    <?php endif; ?>

    <p><strong>Poll Question:</strong> <?= htmlspecialchars($poll['question']) ?></p>
    <ul>
        <?php foreach($options as $opt): ?>
            <li><strong><?= htmlspecialchars($opt['option_text']) ?></strong> — <?= $opt['votes'] ?> votes</li>
        <?php endforeach; ?>
    </ul>

    <form method="POST" onsubmit="return confirm('Are you sure you want to reset all votes?');">
        <button type="submit" name="reset_votes" class="btn">🔁 Reset All Votes</button>
    </form>
</div>

<!-- Footer -->
<div class="footer">
    &copy;<?= date('Y') ?> 2025. Developed by AAU, ICT (WDM)<br/>
    AAU E-VOTING SYSTEM<br/>
    Email: <a href="mailto:webmaster@aauekpoma.edu.ng">webmaster@aauekpoma.edu.ng</a>
</div>

</body>
</html>
