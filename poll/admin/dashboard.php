<?php
ini_set('session.cookie_samesite', 'Lax');
ini_set('session.use_strict_mode', 1);
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: .../login.php');
    exit();
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
            background: #f4f6f9;
        }

        .header {
            background-color: black;
            color: white;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .header img.logo {
            height: 40px;
        }

        .header-title {
            flex-grow: 1;
            text-align: center;
            font-size: 22px;
            font-weight: bold;
        }

        .footer {
            background: #111;
            color: white;
            text-align: center;
            padding: 12px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        .dashboard-wrapper {
            display: flex;
            min-height: calc(100vh - 110px);
        }

        .sidebar {
            width: 220px;
            background: #222;
            color: white;
            padding: 20px;
            min-height: 100%;
        }

        .sidebar h3 {
            margin-bottom: 20px;
        }

        .sidebar a {
            color: #ddd;
            text-decoration: none;
            display: block;
            padding: 10px 0;
            font-size: 16px;
        }

        .sidebar a:hover {
            color: white;
            background: #444;
            padding-left: 10px;
        }

        .main-content {
            flex: 1;
            padding: 30px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .table th, .table td {
            padding: 14px;
            border-bottom: 1px solid #ddd;
        }

        .table th {
            background: #333;
            color: white;
            text-align: left;
        }

        .table tr:nth-child(even) {
            background: #f9f9f9;
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

            .header-title {
                text-align: center;
                width: 100%;
                margin-top: 10px;
            }

            .header {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>
<body>

<!-- Header -->
<div class="header">
    <img src="../assets/logo.png" alt="AAU Logo" class="logo">
    <div class="header-title">AAU Voting System</div>
</div>

<!-- Main Content Wrapper -->
<div class="dashboard-wrapper">

    <!-- Sidebar -->
    <div class="sidebar">
        <h3>Menu</h3>
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
                <td>See real-time poll results and votes per option.</td>
            </tr>
            <tr>
                <td><a href="reset_votes.php">Reset All Votes</a></td>
                <td>Clear all current votes and restart the poll cleanly.</td>
            </tr>
        </table>
    </div>

</div>

<!-- Footer -->
<div class="footer">
    &copy; <?= date('Y') ?> WDM, ICT, AAU - Voting System
</div>

</body>
</html>
