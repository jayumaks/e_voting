<?php 
require 'dbcon.php';

if (isset($_POST['save'])){
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $gender = $_POST['gender'];
    $id_number = $_POST['id_number'];
    $prog_study = $_POST['prog_study'];
    $year_level = $_POST['year_level'];
    $password = $_POST['password'];
    $password1 = $_POST['password1'];
    $date = date("Y-m-d H:i:s");

    $query = $conn->query("SELECT * FROM ids WHERE id_number='$id_number'") or die ($conn->error);
    $count = $query->fetch_array();

    if ($count < 1){
        echo "<script>alert('Invalid Student ID'); window.location='index.php';</script>";
    } else {
        $query = $conn->query("SELECT * FROM voters WHERE id_number='$id_number'") or die ($conn->error);
        $count1 = $query->fetch_array();

        if ($count1 == 0) {
            if ($password == $password1) {
                $conn->query("INSERT INTO voters(id_number, password, firstname, lastname, gender, prog_study, year_level, status, date)
                              VALUES('$id_number', '".md5($password)."', '$firstname', '$lastname', '$gender', '$prog_study', '$year_level', 'Active', '$date')");
                
                // ✅ Show password popup before redirect
                echo "
                    <script>
                        alert('Successfully Registered. Please copy and keep your password safe: \\n\\nPassword: $password');
                        window.location='../voters.php';
                    </script>
                ";
            } else {
                echo "<script>alert('Your Passwords Did Not Match'); window.location='index.php';</script>";
            }
        } else {
            echo "<script>alert('ID Already Registered'); window.location='../voters.php';</script>";
        }
    }
}
?>
