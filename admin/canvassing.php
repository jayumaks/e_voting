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

                foreach ($positions as $position):
                ?>
                    <h4 class="mt-4 alert alert-info">📌 Candidates for <?= $position ?></h4>
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th style="width:45%">Candidate Name</th>
                                <th style="width:20%">Image</th>
                                <th style="width:10%">Total Votes</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = $conn->prepare("SELECT candidate_id, firstname, lastname, img FROM candidate WHERE position = ?");
                            $query->bind_param("s", $position);
                            $query->execute();
                            $result = $query->get_result();
                            while ($row = $result->fetch_assoc()):
                                $cand_id = $row['candidate_id'];
                                $voteQ = $conn->query("SELECT COUNT(*) AS total FROM votes WHERE candidate_id = '$cand_id'");
                                $voteCount = $voteQ->fetch_assoc()['total'];
                            ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['firstname'] . ' ' . $row['lastname']) ?></td>
                                    <td><img src="<?= htmlspecialchars($row['img']) ?>" width="50" height="50" style="border-radius:50%"></td>
                                    <td class="text-center">
                                        <button class="btn btn-primary" disabled><?= $voteCount ?></button>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
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

