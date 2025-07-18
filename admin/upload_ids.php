<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include('session.php'); ?>
<?php include('head.php'); ?>
<?php require_once 'dbcon.php'; ?>

<body>
<div id="wrapper">
    <?php include('side_bar.php'); ?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">Upload Student IDs & Emails</h3>
            </div>

            <div class="panel panel-default">
                <div class="panel-body">
                    <?php
                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csv_file'])) {
                        $file = $_FILES['csv_file']['tmp_name'];

                        if (($handle = fopen($file, 'r')) !== FALSE) {
                            $row = 0;
                            $successCount = 0;
                            $errorCount = 0;
                            $errorLog = [];

                            while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                                if ($row == 0) { $row++; continue; } // Skip header

                                $id     = mysqli_real_escape_string($conn, trim($data[0]));
                                $matric = mysqli_real_escape_string($conn, trim($data[1]));
                                $name   = mysqli_real_escape_string($conn, trim($data[2]));
                                $year   = mysqli_real_escape_string($conn, trim($data[3]));
                                $email  = mysqli_real_escape_string($conn, trim($data[4]));

                                // Validate required fields
                                if (!$id || !$email) {
                                    $errorCount++;
                                    $errorLog[] = "Row $row: Missing ID or email.";
                                    $row++;
                                    continue;
                                }

                                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                    $errorCount++;
                                    $errorLog[] = "Row $row: Invalid email format - $email";
                                    $row++;
                                    continue;
                                }

                                $insert = $conn->query("INSERT INTO ids (id_number, matric_number, names, started, email)
                                    VALUES ('$id', '$matric', '$name', '$year', '$email')
                                    ON DUPLICATE KEY UPDATE
                                        matric_number = '$matric',
                                        names = '$name',
                                        started = '$year',
                                        email = '$email'");

                                if ($insert) {
                                    $successCount++;
                                } else {
                                    $errorCount++;
                                    $errorLog[] = "Row $row: DB Error - " . $conn->error;
                                }
                                $row++;
                            }

                            fclose($handle);

                            echo "<div class='alert alert-success'>Upload complete: <strong>$successCount success</strong>, <strong>$errorCount failed</strong>.</div>";

                            if (!empty($errorLog)) {
                                echo "<div class='alert alert-warning'><strong>Error log:</strong><ul>";
                                foreach ($errorLog as $error) {
                                    echo "<li>$error</li>";
                                }
                                echo "</ul></div>";
                            }
                        } else {
                            echo "<div class='alert alert-danger'>Unable to open the uploaded file.</div>";
                        }
                    }
                    ?>

                    <form method="post" enctype="multipart/form-data" class="form-inline">
                        <div class="form-group">
                            <label for="csv_file">Select CSV File:</label>
                            <input type="file" name="csv_file" id="csv_file" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </form>

                    <hr>
                    <p><strong>CSV Format:</strong> id_number, matric_number, names, started, email</p>
                    <p><em>Make sure your CSV includes headers in the first row.</em></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('script.php'); ?>
</body>
</html>
