<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include('../dbcon.php');

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

// Handle reset action
if (isset($_GET['reset_id'])) {
    $voter_id = $_GET['reset_id'];

    // Get the voter's previous vote
    $stmt = $pdo->prepare("SELECT option_id FROM poll_votes WHERE voter_id = ?");
    $stmt->execute([$voter_id]);
    $vote = $stmt->fetch();

    if ($vote) {
        // Decrement the vote count in options table
        $pdo->prepare("UPDATE options SET votes = votes - 1 WHERE id = ?")->execute([$vote['option_id']]);

        // Delete the vote record
        $pdo->prepare("DELETE FROM poll_votes WHERE voter_id = ?")->execute([$voter_id]);
    }

    // Update voter status
    $pdo->prepare("UPDATE voters SET voted = 0 WHERE voters_id = ?")->execute([$voter_id]);

    header("Location: view_voters.php");
    exit;
}


// Fetch all students
$students = $pdo->query("SELECT * FROM voters ORDER BY firstname")->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html>

<head>
    <title>Registered Voters</title>
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: white;
        }

        a.reset-link {
            background-color: #c00;
            color: white;
            padding: 4px 10px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
        }

        a.reset-link:hover {
            background-color: #a00;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Registered Voters</h2>
        <?php if (count($students) === 0): ?>
            <p>No students found in the database.</p>
        <?php else: ?>
            <table>
                <tr>
                    <th>Full Name</th>
                    <th>Student ID</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($students as $s): ?>
                    <tr>
                        <td><?= htmlspecialchars($s['firstname'] . ' ' . $s['lastname']) ?></td>
                        <td><?= htmlspecialchars($s['id_number']) ?></td>

                        <td><?= isset($s['voted']) && $s['voted'] ? 'Voted' : 'Not Voted' ?></td>
                        <td>
                            <?php if (!empty($s['voted'])): ?>
                                <a href="?reset_id=<?= $s['voters_id'] ?>" class="reset-link" onclick="return confirm('Reset vote for <?= htmlspecialchars($s['fullname']) ?>?');">Reset Vote</a>
                            <?php else: ?>
                                —
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>
</body>

</html>