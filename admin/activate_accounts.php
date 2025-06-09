 <?php 
	require_once 'dbcon.php';						
	$conn->query("UPDATE voters SET status = '1' WHERE id = $student_id
")or die($conn->error);
	echo "<script> window.location='voters.php' </script>";
?>			 
