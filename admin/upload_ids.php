<?php include ('session.php');?>
<?php include ('head.php');?>

<?php
require_once '../dbcon.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csv_file'])) {
    $file = $_FILES['csv_file']['tmp_name'];

    if (($handle = fopen($file, 'r')) !== FALSE) {
        $row = 0;
        while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
            if ($row == 0) { $row++; continue; } // Skip header
            $id = mysqli_real_escape_string($conn, trim($data[0]));
            $matric = mysqli_real_escape_string($conn, trim($data[1]));
            $name = mysqli_real_escape_string($conn, trim($data[2]));
            $year = mysqli_real_escape_string($conn, trim($data[3]));
            $email = mysqli_real_escape_string($conn, trim($data[4]));

            $conn->query("INSERT INTO ids (id_number, matric_number, names, started, email)
                          VALUES ('$id', '$matric', '$name', '$year', '$email')
                          ON DUPLICATE KEY UPDATE email='$email', names='$name', started='$year', matric_number='$matric'");
        }
        fclose($handle);
        echo "<script>alert('Upload successful!'); window.location='add_student_id.php';</script>";
    }
}
?>
<form method="post" enctype="multipart/form-data">
  <input type="file" name="csv_file" required>
  <button type="submit">Upload CSV</button>
</form>
