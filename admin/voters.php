<?php include ('session.php');?>
<?php include ('head.php');?>

<body>
    <div id="wrapper">

        <!-- Navigation -->
        <?php include ('side_bar.php');?>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">Student Voter List</h3>

                </div>
				<?php
					$count = $conn->query("SELECT COUNT(*) as total FROM `voters`")->fetch_array();
					$count1 =  $conn->query("SELECT COUNT(*) as total FROM `voters` WHERE `status` = 'Voted'")->fetch_array();
					$count2 = $conn->query("SELECT COUNT(*) as total FROM `voters` WHERE `status` = 'Unvoted'")->fetch_array();
                    $count3 = $conn->query("SELECT COUNT(*) as total FROM `voters` WHERE `gender` = 'Male' ")->fetch_array();
                    $count4 =  $conn->query("SELECT COUNT(*) as total FROM `voters` WHERE `gender` = 'Female'")->fetch_array();
					?>
				<a href="voters.php" class = "btn btn-primary btn-outline"><i class = "fa fa-paw"></i> ALL Voters (<?php echo $count['total']?>)</a>
				<a href="voted.php" class = "btn btn-success btn-outline"><i class = "fa fa-paw"></i> Voted(<?php echo $count1['total']?>)</a>
				<a href="unvoted.php" class = "btn btn-danger btn-outline"><i class = "fa fa-paw"></i> Unvoted(<?php echo $count2['total']?>) </a><p><br clear = all><p/>
                <a href=" " class = "btn btn-danger btn-outline"><i class = "fa fa-paw"></i> Males(<?php echo $count3['total']?>)</a>
                <a href=" " class = "btn btn-danger btn-outline"><i class = "fa fa-paw"></i> Females(<?php echo $count4['total']?>)</a>
                 <a href="voters_excel.php"><button type="button" style = "margin-right:14px;" id ="print" class = "pull-right btn btn-info"><i class = "fa fa-print"></i>Export Voters to Excel</button></a>
                 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;

				<a  href = "activate_accounts.php"class = "btn btn-danger btn-outline pull-right" style = "margin-right:12px;" name = "go"><i>Activate Voter Accounts</i> </a>
				<a  href = "deactivate_accounts.php"class = "btn btn-danger btn-outline pull-right" style = "margin-right:12px;" name = "go"><i>Deactivate Voter Accounts</i> </a>

				<br />
				<br />

				<hr/>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="modal-title" id="myModalLabel">
												<div class="panel panel-primary">
													<div class="panel-heading"><i class = "fa fa-users"></i>
														Voters List
													</div>
												</div>
											</h4>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>

                                            <th>Student ID</th>
                                            <th>Names</th>
                                            <th>Gender</th>
                                            <th>Program of Sstudy</th>
                                            <th>Year Level</th>
                                            <th>Account</th>
                                            <th>Status</th>
                                            <th>Date Registered</th>


                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            require 'dbcon.php';

                                            $query = $conn->query("SELECT * FROM voters ORDER BY voters_id DESC");
                                            while($row1 = $query->fetch_array()){
                                            $voters_id=$row1['voters_id'];
                                        ?>

                                            <tr >
                                                <td><?php echo $row1 ['id_number'];?></td>
                                                <td><?php echo $row1 ['firstname']." ". $row1 ['lastname'];?></td>
                                                <td><?php echo $row1 ['gender'];?></td>
                                                <td><?php echo $row1['prog_study'];?></td>
                                                <td><?php echo $row1 ['year_level'];?></td>
                                                <td><?php echo $row1 ['account'];?></td>
                                                <td><?php echo $row1 ['status'];?></td>
                                                <td><?php echo $row1 ['date'];?></td>

                                    </tr>



                                       <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->

                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->

            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->



    </div>
    <!-- /#wrapper -->

    <?php include ('script.php');?>

</body>

</html>

