<?php
session_start();
include('../dbcon.php');

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

// Handle reset action
if (isset($_GET['reset_id'])) {
    $stmt = $pdo->prepare("UPDATE students SET voted = 0 WHERE id = ?");
    $stmt->execute([$_GET['reset_id']]);
    header("Location: view_voters.php"); // Refresh page
    exit;
}

// Fetch all students
$students = $pdo->query("SELECT * FROM students ORDER BY fullname")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Registered Voters</title>
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .container { max-width: 900px; margin: 0 auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background-color: #333; color: white; }
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
                    <td><?= htmlspecialchars($s['fullname']) ?></td>
                    <td><?= htmlspecialchars($s['matric_no']) ?></td>
                    <td><?= isset($s['voted']) && $s['voted'] ? 'Voted' : 'Not Voted' ?></td>
                    <td>
                        <?php if (!empty($s['voted'])): ?>
                            <a href="?reset_id=<?= $s['id'] ?>" class="reset-link" onclick="return confirm('Reset vote for <?= htmlspecialchars($s['fullname']) ?>?');">Reset Vote</a>
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
