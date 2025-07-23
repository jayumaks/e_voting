<?php
require_once 'admin/dbcon.php';

$positions = ['President', 'Vice President', 'Treasurer', 'Secretary General', 'Welfare', 'Publicity Secretary'];
$data = [];

foreach ($positions as $position) {
    $query = $conn->prepare("
        SELECT firstname, lastname,
            (SELECT COUNT(*) FROM votes WHERE candidate_id = c.candidate_id) as total
        FROM candidate c
        WHERE position = ?
    ");
    $query->bind_param("s", $position);
    $query->execute();
    $result = $query->get_result();

    $labels = [];
    $votes = [];

    while ($row = $result->fetch_assoc()) {
        $labels[] = $row['firstname'] . ' ' . $row['lastname'];
        $votes[] = (int) $row['total'];
    }

    $data[] = [
        'position' => $position,
        'labels' => $labels,
        'votes' => $votes
    ];

    $query->close();
}

header('Content-Type: application/json');
echo json_encode($data);
