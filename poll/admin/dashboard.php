<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - AAU Voting</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: #f5f6fa;
        }

        .header, .footer {
            background-color: black;
            color: white;
            text-align: center;
            padding: 15px 20px;
        }

        .dashboard-wrapper {
            display: flex;
            flex-wrap: wrap;
            min-height: calc(100vh - 100px); /* Adjust based on header/footer */
        }

        .sidebar {
            background: #222;
            color: white;
            width: 220px;
            padding: 20px;
            min-height: 100%;
        }

        .sidebar h3 {
            color: #fff;
            margin-bottom: 20px;
        }

        .sidebar a {
            color: #ddd;
            text-decoration: none;
            display: block;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .sidebar a:hover {
            color: #fff;
            text-decoration: underline;
        }

        .main-content {
            flex: 1;
            padding: 30px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
            border-radius: 6px;
            overflow: hidden;
        }

        .table th, .table td {
            padding: 15px;
            text-align: left;
        }

        .table th {
            background-color: #333;
            color: white;
        }

        .table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        @media (max-width: 768px) {
            .dashboard-wrapper {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                text-align: center;
            }

            .main-content {
                padding: 15px;
            }
        }
    </style>
</head>
<body>

<!-- Header -->
<div class="header">
    <h1>AAU Voting Admin Panel</h1>
</div>

<!-- Content -->
<div class="dashboard-wrapper">
    <!-- Sidebar -->
    <div class="sidebar">
        <h3>Navigation</h3>
        <a href="voters.php">👥 Voter List</a>
        <a href="poll_report.php">📊 Poll Report</a>
        <a href="reset_votes.php">🔁 Reset Votes</a>
        <a href="logout.php">🚪 Logout</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <h2>Welcome, Admin!</h2>
        <table class="table">
            <tr>
                <th>Quick Access</th>
                <th>Description</th>
            </tr>
            <tr>
                <td><a href="voters.php">View Voters</a></td>
                <td>See all registered voters and their voting status.</td>
            </tr>
            <tr>
                <td><a href="poll_report.php">Poll Report</a></td>
                <td>View current opinion poll results and stats.</td>
            </tr>
            <tr>
                <td><a href="reset_votes.php">Reset Votes</a></td>
                <td>Clear all votes and restart the poll.</td>
            </tr>
        </table>
    </div>
</div>

<!-- Footer -->
<div class="footer">
    &copy; <?php echo date('Y'); ?> Ambrose Alli University - Voting System Admin
</div>

</body>
</html>
