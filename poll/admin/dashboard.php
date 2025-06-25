<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard Analytics</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link rel="stylesheet" href="../assets/style.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f5f5f5;
    }
    .header, .footer {
      background-color: #000;
      color: white;
      padding: 15px;
      text-align: center;
    }
    .content {
      max-width: 960px;
      margin: 20px auto;
      background: white;
      padding: 20px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      border-radius: 6px;
    }
    canvas {
      max-width: 100%;
    }
  </style>
</head>
<body>

<div class="header">
  <h1>Voting Analytics Dashboard</h1>
</div>

<div class="content">
  <h2>Poll Results (Live)</h2>
  <canvas id="pollChart" height="120"></canvas>
</div>

<div class="footer">
  &copy; <?php echo date('Y'); ?> Ambrose Alli University - Voting System Admin
</div>

<script>
  // Replace this with dynamic PHP data later
  const labels = <?php echo json_encode($optionLabels); ?>;
  const voteData = <?php echo json_encode($voteTotals); ?>;

  const ctx = document.getElementById('pollChart').getContext('2d');
  const pollChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: labels,
      datasets: [{
        label: 'Number of Votes',
        data: voteData,
        backgroundColor: '#007bff',
        borderColor: '#0056b3',
        borderWidth: 1,
      }]
    },
    options: {
      responsive: true,
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
