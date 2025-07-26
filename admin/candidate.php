<?php
session_start();
require 'dbcon.php';

// Handle candidate submission BEFORE HTML is rendered
if (isset($_POST['save'])) {
    $party = $_POST['party'];
    $position = $_POST['position'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $year_level = $_POST['year_level'];
    $gender = $_POST['gender'];

    $image = $_FILES['image'];
    $image_name = addslashes($image['name']);
    $tmp_name = $image['tmp_name'];
    $location = "upload/" . $image_name;

    if (move_uploaded_file($tmp_name, $location)) {
        $stmt = $conn->prepare("INSERT INTO candidate(position, party, firstname, lastname, year_level, gender, img) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $position, $party, $firstname, $lastname, $year_level, $gender, $location);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Candidate added successfully.";
        } else {
            $_SESSION['error'] = "Failed to add candidate: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $_SESSION['error'] = "Image upload failed.";
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>

<?php include('session.php'); ?>
<?php include('head.php'); ?>

<body>
<div id="wrapper">

    <?php include('side_bar.php'); ?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">Candidate List</h3>
            </div>

            <!-- Flash Messages -->
            <div class="col-md-12">
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
                <?php endif; ?>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
                <?php endif; ?>
            </div>

            <div class="col-md-12">
                <button class="btn btn-success" data-toggle="modal" data-target="#myModal">Add Candidate</button>
                <a href="candidate_excel.php" class="btn btn-info pull-right" style="margin-right:14px;">
                    <i class="fa fa-print"></i> Export to Excel
                </a>
            </div>
        </div>

        <hr/>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="modal-title">Candidate List</h4>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                        <tr>
                            <th>Image</th>
                            <th>Position</th>
                            <th>Party</th>
                            <th>Firstname</th>
                            <th>Lastname</th>
                            <th>Year Level</th>
                            <th>Gender</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $query = $conn->query("SELECT * FROM candidate ORDER BY candidate_id DESC");
                        while ($row = $query->fetch_array()):
                            $candidate_id = $row['candidate_id'];
                            ?>
                            <tr>
                                <td><img src="<?= $row['img']; ?>" width="50" height="50" class="img-rounded"></td>
                                <td><?= $row['position']; ?></td>
                                <td><?= $row['party']; ?></td>
                                <td><?= $row['firstname']; ?></td>
                                <td><?= $row['lastname']; ?></td>
                                <td><?= $row['year_level']; ?></td>
                                <td><?= $row['gender']; ?></td>
                                <td style="text-align:center">
                                    <a href="#delete_user<?= $candidate_id; ?>" data-toggle="modal" class="btn btn-danger btn-outline">
                                        <i class="fa fa-trash-o"></i> Delete
                                    </a>
                                    <?php include('delete_candidate_modal.php'); ?>

                                    <a href="#edit_candidate<?= $candidate_id; ?>" data-toggle="modal" class="btn btn-success btn-outline">
                                        <i class="fa fa-pencil"></i> Edit
                                    </a>
                                    <?php include('edit_candidate_modal.php'); ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div> <!-- /#page-wrapper -->

</div> <!-- /#wrapper -->

<!-- Modal for Add Candidate -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Candidate</h4>
            </div>

            <div class="modal-body">
                <form method="post" action="candidate.php" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Position</label>
                        <select class="form-control" name="position" required>
                            <option selected disabled>Select Candidate Group</option>
                            <option>FACULTY CLASS REP OF THE YEAR(FBMS)</option>
                            <option>Vice President</option>
                            <option>Treasurer</option>
                            <option>Secretary General</option>
                            <option>Welfare</option>
                            <option>PRO</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Party Name</label>
                        <input class="form-control" type="text" name="party" placeholder="Enter party name" required>
                    </div>

                    <div class="form-group">
                        <label>Firstname</label>
                        <input class="form-control" type="text" name="firstname" placeholder="Enter firstname" required>
                    </div>

                    <div class="form-group">
                        <label>Lastname</label>
                        <input class="form-control" type="text" name="lastname" placeholder="Enter lastname" required>
                    </div>

                    <div class="form-group">
                        <label>Year Level</label>
                        <select class="form-control" name="year_level" required>
                            <option selected disabled>Select Level</option>
                            <option>1st Year</option>
                            <option>2nd Year</option>
                            <option>3rd Year</option>
                            <option>4th Year</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Gender</label>
                        <select class="form-control" name="gender" required>
                            <option selected disabled>Select Gender</option>
                            <option>Male</option>
                            <option>Female</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Image</label>
                        <input type="file" name="image" class="form-control" required>
                    </div>

                    <button name="save" type="submit" class="btn btn-primary">Save Candidate</button>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

<!-- Auto-show modal if error exists -->
<?php if (isset($_SESSION['error'])): ?>
    <script>
        $(document).ready(function () {
            $('#myModal').modal('show');
        });
    </script>
<?php endif; ?>

<?php include('script.php'); ?>
</body>
</html>
