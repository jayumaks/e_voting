<?php
require_once 'admin/dbcon.php';
header("Refresh: 10"); // Auto-refresh every 10 seconds
?>

<!DOCTYPE html>
<html>
<head>
    <title>📊 Live Vote Results</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            padding: 20px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .chart-container {
            width: 100%;
            max-width: 1000px;
            margin: 40px auto;
        }
        canvas {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

<h2>📊 Live Vote Results</h2>

<div class="chart-container">
    <canvas id="voteChart"></canvas>
</div>

<?php
$query = $conn->query("
    SELECT
        c.firstname,
        c.lastname,
        c.position,
        COUNT(v.vote_id) AS vote_count
    FROM candidate c
    LEFT JOIN votes v ON c.candidate_id = v.candidate_id
    GROUP BY c.candidate_id
    ORDER BY c.position, c.firstname
");

$labels = [];
$voteCounts = [];
$colors = [];

$positionColors = [
    'President' => 'rgba(54, 162, 235, 0.8)',
    'Vice President' => 'rgba(255, 99, 132, 0.8)',
    'Treasurer' => 'rgba(255, 206, 86, 0.8)',
    'Secretary General' => 'rgba(75, 192, 192, 0.8)',
    'Welfare' => 'rgba(153, 102, 255, 0.8)',
    'Publicity Secretary' => 'rgba(255, 159, 64, 0.8)',
];

while ($row = $query->fetch_assoc()) {
    $labels[] = "{$row['firstname']} {$row['lastname']} ({$row['position']})";
    $voteCounts[] = $row['vote_count'];
    $colors[] = $positionColors[$row['position']] ?? 'rgba(100,100,100,0.8)';
}
?>

<script>
    const ctx = document.getElementById('voteChart').getContext('2d');
    const voteChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($labels); ?>,
            datasets: [{
                label: 'Votes',
                data: <?= json_encode($voteCounts); ?>,
                backgroundColor: <?= json_encode($colors); ?>,
                borderRadius: 5,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: false,
            scales: {
                y: {
                    beginAtZero: true,
                    title: { display: true, text: 'Number of Votes' }
                },
                x: {
                    ticks: {
                        maxRotation: 90,
                        minRotation: 30
                    }
                }
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `Votes: ${context.raw}`;
                        }
                    }
                }
            }
        }
    });
</script>

</body>
</html>
