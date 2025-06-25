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
            cursor: pointer;
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

        .hidden {
            display: none;
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

<!-- Dashboard Layout -->
<div class="dashboard-wrapper">
    <!-- Sidebar -->
    <div class="sidebar">
        <h3>Menu</h3>
        <a onclick="showSection('dashboard')">📊 Dashboard</a>
        <a onclick="showSection('voters')">👥 Voter List</a>
        <a onclick="showSection('report')">📈 Poll Report</a>
        <a onclick="showSection('reset')">🔁 Reset Votes</a>
        <a href="logout.php">🚪 Logout</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Dashboard -->
        <div id="dashboard-section">
            <h2>Welcome, Admin!</h2>
            <p>Use the menu to manage voting activities.</p>
        </div>

        <!-- Voter List -->
        <div id="voters-section" class="hidden">
            <h2>Registered Voters</h2>
            <table class="table">
                <tr><th>Name</th><th>Student ID</th><th>Status</th></tr>
                <?php
                include('../dbcon.php');
                $students = $pdo->query("SELECT * FROM voters ORDER BY fullname")->fetchAll();
                foreach ($students as $s) {
                    echo "<tr>
                        <td>" . htmlspecialchars($s['fullname']) . "</td>
                        <td>" . htmlspecialchars($s['id_number']) . "</td>
                        <td>" . ($s['voted'] ? 'Voted' : 'Not Voted') . "</td>
                    </tr>";
                }
                ?>
            </table>
        </div>

        <!-- Poll Report -->
        <div id="report-section" class="hidden">
            <h2>Poll Report</h2>
            <?php
            $poll = $pdo->query("SELECT * FROM poll LIMIT 1")->fetch();
            echo "<p><strong>Question:</strong> " . htmlspecialchars($poll['question']) . "</p>";
            $options = $pdo->prepare("SELECT * FROM options WHERE poll_id = ?");
            $options->execute([$poll['id']]);
            echo "<ul>";
            foreach ($options as $opt) {
                echo "<li>" . htmlspecialchars($opt['option_text']) . " - " . $opt['votes'] . " votes</li>";
            }
            echo "</ul>";
            ?>
        </div>

        <!-- Reset Votes -->
        <div id="reset-section" class="hidden">
            <h2>Reset All Votes</h2>
            <form method="post" action="reset_votes.php" onsubmit="return confirm('Are you sure you want to reset all votes?');">
                <button type="submit" style="padding: 10px 20px; background: red; color: white; border: none; border-radius: 5px;">Reset All</button>
            </form>
        </div>
    </div>
</div>

<!-- Footer -->
<div class="footer">
    &copy; <?= date('Y') ?> Ambrose Alli University - Voting System
</div>

<!-- Script to toggle sections -->
<script>
    function showSection(id) {
        const sections = ['dashboard', 'voters', 'report', 'reset'];
        sections.forEach(sec => {
            document.getElementById(sec + '-section').classList.add('hidden');
        });
        document.getElementById(id + '-section').classList.remove('hidden');
    }
</script>

</body>
</html>
