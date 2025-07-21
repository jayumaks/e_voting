<?php include('session.php'); ?>
<?php include('head.php'); ?>

<body>
	<div id="wrapper">

		<?php include('side_bar.php'); ?>
		<div id="page-wrapper">
			<div class="container-fluid">

				<h3 class="text-center mt-4"><i class="fa fa-briefcase"></i> General Election Report</h3>
				<hr>

				<div class="alert alert-success">
					<strong>Election Result Summary</strong>
				</div>

				<!-- Sorting and Export Buttons -->
				<form method="post" action="sort.php" class="form-inline mb-3">
					<select name="position" class="form-control" style="width: 250px;">
						<option readonly>----Sort by Position----</option>
						<option></option>
						<option>President</option>
						<option>Vice President</option>
						<option>Treasurer</option>
						<option>Secretary General</option>
						<option>Welfare</option>
						<option>Publicity Secretary</option>
					</select>
<a href="reset_votes.php" onclick="return confirm('⚠️ Are you sure you want to reset all votes?');">
						<button class="btn btn-danger"><i class="fa fa-trash"></i> Reset Votes</button>
					</a>
					<button type="submit" class="btn btn-success mx-2">Sort</button>
					<button type="button" onclick="window.print();" class="btn btn-info mx-1"><i class="fa fa-print"></i> Print</button>
					<a href="excel.php" class="btn btn-info mx-1"><i class="fa fa-download"></i> Export to Excel</a>


				</form>

				<?php
				require 'dbcon.php';

				// Total votes cast overall
				$totalVotesCast = $conn->query("SELECT COUNT(*) as total FROM votes")->fetch_assoc()['total'];
				echo "<div class='alert alert-info'><strong>Total Votes Cast:</strong> {$totalVotesCast}</div>";

				// Positions to report
				$positions = ['President', 'Vice President', 'Treasurer', 'Secretary General', 'Welfare', 'Publicity Secretary'];

				foreach ($positions as $position):

					// Total votes for current position
					$positionVotesResult = $conn->query("
                    SELECT COUNT(*) as total
                    FROM votes
                    WHERE candidate_id IN (
                        SELECT candidate_id FROM candidate WHERE position = '$position'
                    )
                ");
					$positionTotalVotes = $positionVotesResult->fetch_assoc()['total'];
				?>

					<div class="panel panel-info">
						<div class="panel-heading">
							<i class="fa fa-thumbtack"></i> Candidates for <strong><?= strtoupper($position) ?></strong>
						</div>
						<div class="panel-body">
							<table class="table table-striped table-bordered table-hover">
								<thead class="bg-primary text-white">
									<tr>
										<th>Candidate Name</th>
										<th>Image</th>
										<th>Votes</th>
										<th>% of Total Votes (Position)</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$query = $conn->query("
                            SELECT
                                c.candidate_id,
                                c.firstname,
                                c.lastname,
                                c.img,
                                COUNT(v.vote_id) AS votes
                            FROM candidate c
                            LEFT JOIN votes v ON c.candidate_id = v.candidate_id
                            WHERE c.position = '$position'
                            GROUP BY c.candidate_id
                        ");

									while ($row = $query->fetch_assoc()):
										$fullname = $row['firstname'] . " " . $row['lastname'];
										$votes = $row['votes'];
										$percentage = ($positionTotalVotes > 0) ? round(($votes / $positionTotalVotes) * 100, 2) : 0;
									?>
										<tr>
											<td><?= htmlspecialchars($fullname) ?></td>
											<td><img src="<?= htmlspecialchars($row['img']) ?>" width="40" height="40" style="border-radius: 50%;"></td>
											<td><button class="btn btn-sm btn-primary" disabled><?= $votes ?></button></td>
											<td><?= $percentage ?>%</td>
										</tr>
									<?php endwhile; ?>
								</tbody>
							</table>
						</div>
					</div>

				<?php endforeach; ?>

			</div>
		</div>
	</div>

	<?php include('script.php'); ?>
</body>

</html>