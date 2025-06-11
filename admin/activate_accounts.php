

<?php
require_once 'dbcon.php'; // Ensure this connects successfully and assigns to $conn

// 1. Get the student_id securely and validate it
// Assuming the student_id comes from a GET request (e.g., voters.php?student_id=E1034567)
// Adjust to $_POST['student_id'] if it's from a form submission
$student_id = isset($_GET['student_id']) ? $_GET['student_id'] : ''; // Get as string, default to empty

// Trim whitespace and ensure it's not empty after trimming
$student_id = trim($student_id);

// Check if a valid (non-empty) student ID was received
if (empty($student_id)) {
    // If no valid ID, redirect back with an error or display a message
    echo "Error: No valid student ID provided for activation.";
    // Optionally, redirect
    // echo "<script> window.location='voters.php?error=no_id_provided' </script>";
    exit(); // Stop script execution
}

// 2. Use Prepared Statements for security and correct syntax
// This prevents SQL injection and handles variable types correctly
$stmt = $conn->prepare("UPDATE voters SET status = 'Active' WHERE id = ?");

if ($stmt) {
    // 's' specifies that the parameter is a string type
    $stmt->bind_param("s", $student_id);

    // Execute the statement
    if ($stmt->execute()) {
        // Check if any rows were affected
        if ($stmt->affected_rows > 0) {
            echo "<script> window.location='voters.php' </script>";
        } else {
            // This means the ID existed, but no row was updated.
            // Possibly the status was already 'Active', or the ID didn't exist.
            echo "Notice: Voter with ID {$student_id} not found or status already active. Redirecting...";
            echo "<script> window.location='voters.php' </script>";
        }
    } else {
        // Error during execution
        echo "Error executing statement: " . $stmt->error;
        // Optional: Redirect back with error message
        // echo "<script> window.location='voters.php?error=db_execution_failed' </script>";
    }

    // Close the statement
    $stmt->close();

} else {
    // Error preparing the statement (e.g., SQL syntax error in the statement itself)
    echo "Error preparing statement: " . $conn->error;
    // Optional: Redirect back with error message
    // echo "<script> window.location='voters.php?error=prepare_failed' </script>";
}

// It's good practice to close the connection when done, though it might be handled by script termination
// $conn->close();

?>