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

<?php include('add_candidate_modal.php'); ?>
<?php include('script.php'); ?>
</body>
</html>
