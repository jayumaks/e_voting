<?php include('session.php'); ?>
<?php include('head.php'); ?>

<body>
    <div id="wrapper">

        <!-- Navigation -->
        <?php include('side_bar.php'); ?>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">Current Students</h3>
                    <a href="upload_ids.php" class="btn btn-success btn-outline"><i class="glyphicon glyphicon-save"></i> Import Students Data</a>
                    <a href="add_student_id.php" class="btn btn-success btn-outline"><i class="glyphicon glyphicon-plus"></i> Add Student ID</a>

                    <hr />

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <strong>Manage Student IDs and Emails</strong>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <form method="post" action="bulk_delete.php" onsubmit="return confirm('Are you sure you want to delete selected records?');">
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" id="select-all"></th>
                                                <th>Student ID</th>
                                                <th>Matric Number</th>
                                                <th>Names</th>
                                                <th>Email</th>
                                                <th>Year Registered</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            require 'dbcon.php';
                                            $query = $conn->query("SELECT * FROM ids ORDER BY id_number DESC");
                                            while ($row1 = $query->fetch_array()) {
                                            ?>
                                                <tr>
                                                    <td><input type="checkbox" name="delete_ids[]" value="<?php echo $row1['id_number']; ?>"></td>
                                                    <td><?php echo $row1['id_number']; ?></td>
                                                    <td><?php echo $row1['matric_number']; ?></td>
                                                    <td><?php echo $row1['names']; ?></td>
                                                    <td><?php echo $row1['email']; ?></td>
                                                    <td><?php echo $row1['started']; ?></td>
                                                    <td>
                                                        <a href="delete_student.php?id=<?php echo $row1['id_number']; ?>" onclick="return confirm('Are you sure you want to delete this student?');" class="btn btn-danger btn-sm">Delete</a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                        <button type="submit" class="btn btn-danger" style="margin-bottom: 10px;">Delete Selected</button>
                                    </table>
                                </form>
                                <script>
                                    $(document).ready(function() {
                                        var table = $('#dataTables-example').DataTable({
                                            lengthMenu: [
                                                [10, 25, 50, 100, 500, 1000, -1],
                                                [10, 25, 50, 100, 500, 1000, "All"]
                                            ],
                                            pageLength: -1 // Show all records
                                        });

                                        $('html, body').animate({
                                            scrollTop: $("#dataTables-example").offset().top
                                        }, 500);
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('script.php'); ?>
    <script>
        document.getElementById('select-all').onclick = function() {
            let checkboxes = document.getElementsByName('delete_ids[]');
            for (let checkbox of checkboxes) {
                checkbox.checked = this.checked;
            }
        };
    </script>
</body>
</html>
