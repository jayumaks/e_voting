<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

include('../dbcon.php');
$poll = $pdo->query("SELECT * FROM poll LIMIT 1")->fetch();
$options = $pdo->prepare("SELECT * FROM options WHERE poll_id = ?");
$options->execute([$poll['id']]);

$labels = [];
$votes = [];

foreach ($options as $opt) {
    $labels[] = $opt['option_text'];
    $votes[] = $opt['votes'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Poll Results - AAU Voting</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: #f5f6fa;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: black;
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
            max-width: 900px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        ul {
            padding-left: 20px;
        }

        ul li {
            padding: 10px 0;
            font-size: 16px;
            border-bottom: 1px solid #ddd;
        }

        canvas {
            max-width: 100%;
            margin-top: 40px;
        }

        @media (max-width: 768px) {
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
    <img src="../assets/logo.png" alt="AAU Logo"> <!-- Replace with actual logo path -->
    <nav>
        <a href="../index.php">Home</a>
        <a href="../vote/index.php">Vote</a>
        <a href="../logout.php">Logout</a>
    </nav>
</div>

<!-- Main Content -->
<div class="container">
    <h2>Poll Results: <?= htmlspecialchars($poll['question']) ?></h2>

    <ul>
        <?php foreach ($labels as $i => $label): ?>
            <li><?= htmlspecialchars($label) ?> - <?= $votes[$i] ?> vote<?= $votes[$i] != 1 ? 's' : '' ?></li>
        <?php endforeach; ?>
    </ul>

    <!-- Chart Container -->
    <canvas id="pollChart" height="100"></canvas>
</div>

<!-- Chart Script -->
<script>
    const ctx = document.getElementById('pollChart').getContext('2d');
    const pollChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($labels) ?>,
            datasets: [{
                label: 'Number of Votes',
                data: <?= json_encode($votes) ?>,
                backgroundColor: 'rgba(0,123,255,0.7)',
                borderColor: 'rgba(0,123,255,1)',
                borderWidth: 1,
                borderRadius: 5
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                title: {
                    display: true,
                    text: 'Voting Results (Live Totals)',
                    padding: {
                        top: 10,
                        bottom: 20
                    },
                    font: {
                        size: 18
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });
</script>

</body>
</html>
