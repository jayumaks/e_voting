<?php
// Top of the file (before any HTML)
session_start();
require_once 'dbcon.php';

if (isset($_POST['save'])) {
    $party = $_POST['party'];
    $position = $_POST['position'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $year_level = $_POST['year_level'];
    $gender = $_POST['gender'];

    // Handle image upload
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


<!-- Add this modal HTML inside your page -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
        <div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Add Candidate</h4>
			</div>

            <div class="modal-body">
				<form method="post" enctype="multipart/form-data">
					<div class="form-group">
						<label>Position</label>
						<select class="form-control" name="position" required>
							<option selected disabled>Select Candidate Group</option>
							<option>President</option>
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
