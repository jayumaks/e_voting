<?php
include('admin/dbcon.php');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Live Vote Results</title>
<meta http-equiv="refresh" content="10">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body style="text-align:center; font-family: Arial; padding: 30px;">

    <h2>📊 Live Vote Results</h2>
    <div id="charts-container"></div>

    <script>
        async function fetchAndUpdateCharts() {
            const response = await fetch('fetch_vote_data.php');
            const data = await response.json();

            const container = document.getElementById('charts-container');
            container.innerHTML = ''; // Clear old charts

            data.forEach((positionData, index) => {
                const canvas = document.createElement('canvas');
                canvas.id = 'chart_' + index;
                canvas.style.maxWidth = '700px';
                canvas.style.margin = '20px auto';
                container.appendChild(canvas);

                new Chart(canvas, {
                    type: 'bar',
                    data: {
                        labels: positionData.labels,
                        datasets: [{
                            label: `${positionData.position} Votes`,
                            data: positionData.votes,
                            backgroundColor: 'rgba(54, 162, 235, 0.6)'
                        }]
                    },
                    options: {
                        plugins: {
                            legend: { display: false }
                        },
                        responsive: true,
                        scales: {
                            y: { beginAtZero: true }
                        }
                    }
                });
            });
        }

        fetchAndUpdateCharts();
        setInterval(fetchAndUpdateCharts, 5000); // Refresh every 5 seconds
    </script>
</body>
</html>
