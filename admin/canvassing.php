<?php include('session.php'); ?>
<?php include('head.php'); ?>
<?php include('admin/dbcon.php'); ?>
<body>
<div id="wrapper">

    <!-- Navigation -->
    <?php include('side_bar.php'); ?>

    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header text-center">🗳️ General Election Report</h3>
                <hr/>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="alert alert-success">Election Result Summary</h4>
            </div>

            <div class="panel-body">
                <!-- Sort Form -->
                <form method="post" action="sort.php" class="form-inline mb-4">
                    <select name="position" id="position" class="form-control mr-2">
                        <option readonly>----Sort by Position----</option>
                        <option>President</option>
                        <option>Vice President</option>
                        <option>Treasurer</option>
                        <option>Secretary General</option>
                        <option>Welfare</option>
                        <option>Publicity Secretary</option>
                    </select>
                    <button type="submit" class="btn btn-success mr-2">Sort</button>
                    <button type="button" onclick="window.print();" class="btn btn-info mr-2">
                        <i class="fa fa-print"></i> Print
                    </button>
                    <a href="excel.php" class="btn btn-info">
                        <i class="fa fa-file-excel-o"></i> Export to Excel
                    </a>
                </form>

                <?php
                $positions = [
                    'President',
                    'Vice President',
                    'Treasurer',
                    'Secretary General',
                    'Welfare',
                    'Publicity Secretary'
                ];

                // Display total votes cast
                $totalVotes = $conn->query("SELECT COUNT(*) as total FROM votes")->fetch_assoc()['total'];
                echo "<div class='alert alert-info'><strong>Total Votes Cast:</strong> $totalVotes</div>";

                foreach ($positions as $position):
                ?>
                    <h4 class="mt-4 alert alert-info">📌 Candidates for <?= $position ?></h4>
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th style="width:35%">Candidate Name</th>
                                <th style="width:15%">Image</th>
                                <th style="width:10%">Votes</th>
                                <th style="width:20%">% of Total Votes (Position)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt = $conn->prepare("SELECT c.candidate_id, c.firstname, c.lastname, c.img, COUNT(v.vote_id) AS total_votes
                                                    FROM candidate c
                                                    LEFT JOIN votes v ON c.candidate_id = v.candidate_id
                                                    WHERE c.position = ?
                                                    GROUP BY c.candidate_id");
                            $stmt->bind_param("s", $position);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            // Calculate total votes for the position
                            $positionTotalVotes = 0;
                            $candidates = [];
                            while ($row = $result->fetch_assoc()) {
                                $candidates[] = $row;
                                $positionTotalVotes += $row['total_votes'];
                            }

                            foreach ($candidates as $row):
                                $percentage = $positionTotalVotes > 0 ? round(($row['total_votes'] / $positionTotalVotes) * 100, 2) : 0;
                            ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['firstname'] . ' ' . $row['lastname']) ?></td>
                                    <td><img src="<?= htmlspecialchars($row['img']) ?>" width="50" height="50" style="border-radius:50%"></td>
                                    <td class="text-center">
                                        <button class="btn btn-primary" disabled><?= $row['total_votes'] ?></button>
                                    </td>
                                    <td class="text-center"> <?= $percentage ?>%</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<?php include('script.php'); ?>
</body>
</html>
