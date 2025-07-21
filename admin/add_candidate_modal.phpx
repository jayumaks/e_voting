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


