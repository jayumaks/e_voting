<?php
require_once 'admin/dbcon.php';
include('session.php'); // If needed for security
include('head.php');
header("Refresh: 60"); // Auto-refresh every 60 seconds
?>

<body>
<?php include('side_bar.php'); ?>

<div class="container-fluid mt-4">
    <h2 class="text-center mb-4">📊 Live Vote Results</h2>

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
    $rows = [];

    $positionColors = [
        'President' => 'rgba(54, 162, 235, 0.8)',
        'Vice President' => 'rgba(255, 99, 132, 0.8)',
        'Treasurer' => 'rgba(255, 206, 86, 0.8)',
        'Secretary General' => 'rgba(75, 192, 192, 0.8)',
        'Welfare' => 'rgba(153, 102, 255, 0.8)',
        'Publicity Secretary' => 'rgba(255, 159, 64, 0.8)',
    ];

    while ($row = $query->fetch_assoc()) {
        $name = "{$row['firstname']} {$row['lastname']}";
        $position = $row['position'];
        $voteCount = $row['vote_count'];

        $labels[] = "$name ($position)";
        $voteCounts[] = $voteCount;
        $colors[] = $positionColors[$position] ?? 'rgba(100,100,100,0.8)';

        $rows[] = [
            'name' => $name,
            'position' => $position,
            'votes' => $voteCount
        ];
    }
    ?>

    <div class="row">
        <!-- Table Section -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    📋 Vote Summary Table
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>Candidate</th>
                                <th>Position</th>
                                <th>Total Votes</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rows as $r): ?>
                                <tr>
                                    <td><?= htmlspecialchars($r['name']) ?></td>
                                    <td><?= htmlspecialchars($r['position']) ?></td>
                                    <td><?= htmlspecialchars($r['votes']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Chart Section -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    📈 Vote Bar Chart
                </div>
                <div class="card-body">
                    <canvas id="voteChart" style="height: 400px;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<?php include('footer.php'); ?>
<?php include('script.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('voteChart').getContext('2d');
const voteChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?= json_encode($labels) ?>,
        datasets: [{
            label: 'Votes',
            data: <?= json_encode($voteCounts) ?>,
            backgroundColor: <?= json_encode($colors) ?>,
            borderRadius: 6,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        animation: false,
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Votes'
                }
            },
            x: {
                ticks: {
                    maxRotation: 60,
                    minRotation: 30
                }
            }
        },
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: {
                    label: ctx => `Votes: ${ctx.raw}`
                }
            }
        }
    }
});
</script>

</body>
</html>
