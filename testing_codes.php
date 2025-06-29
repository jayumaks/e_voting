<?php

	require_once 'admin/dbcon.php';

	if(isset($_POST['login'])){
		$idno=$_POST['idno'];
		$password=$_POST['password'];

		$result = $conn->query("SELECT * FROM voters WHERE id_number = '$idno' && password = '".md5($password)."' && `account` = 'active' && `status` = 'Unvoted'") or die(mysqli_errno());
		$row = $result->fetch_array();
		$voted = $conn->query("SELECT * FROM `voters` WHERE id_number = '$idno' && password = '".md5($password)."' && `status` = 'Voted'")->num_rows;
		$numberOfRows = $result->num_rows;

		if ($numberOfRows > 0){
			session_start();
			$_SESSION['voters_id'] = $row['voters_id'];
			header('location:vote.php');
		}


		if($voted == 1){
			?>
			<script type="text/javascript">
			alert('Sorry You Already Voted')
			</script>
			<?php
		}else{
			?>
			<script type="text/javascript">
			alert('Your account is not Activated')
			</script>
			<?php
		}

	}
?> initial login_query



<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom:0; background-color:black;">
            <div class="navbar-header">
                <a class="navbar-brand" href="index.php" style = "color:white; padding-left:25px;"><i class = "fa fa-home fa-large" > </i>HOME | AAU Online Voting System</a>

            </div>


            <ul class="nav navbar-top-links navbar-right">

               <?php require 'admin/dbcon.php';
				$query = $conn->query("SELECT * from voters where voters_id ='$session_id'")or die (mysql_error ());

				while ($row = $query->fetch_array()){


			 ?>

                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" style = "color: white">
					<i>Welcome: <?php echo $user_username = $user_row['firstname']." ".$user_row['lastname'];?></i>
                    </a>
                </li>
            <li class="dropdown">
                <a href="logout.php"style = "color: white; padding-rignt: 30px;"> <i class = "fa fa-sign-out" style = "color: white"></i>Logout</a>
            </li>

            </ul>
			<?php }?>
        </nav>  ---- SIDEBAR




<?php
$host = 'localhost';
$db = 'aauekpo5_poll';
$user = 'aauekpo5_polldb';
$pass = 'H,KkUno&H#jf8u$(';
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>

POLL


<?php
session_start(); include('../dbcon.php');
if (!isset($_SESSION['admin'])) { header('Location: login.php'); exit; }
$poll = $pdo->query("SELECT * FROM poll LIMIT 1")->fetch();
$options = $pdo->prepare("SELECT * FROM options WHERE poll_id = ?");
$options->execute([$poll['id']]);
?>
<!DOCTYPE html>
<html>
<head><link rel="stylesheet" href="../assets/style.css"></head>
<body>
<div class="container">
<h2>Poll Report</h2>
<p><strong>Question:</strong> <?= $poll['question'] ?></p>
<ul>
<?php foreach($options as $opt): ?>
    <li><?= $opt['option_text'] ?> - <?= $opt['votes'] ?> votes</li>
<?php endforeach; ?>
</ul>
</div>
</body>
</html>REPORT PAGE



<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include('dbcon.php');

// Fetch the latest poll
$poll = $pdo->query("SELECT * FROM poll ORDER BY id DESC LIMIT 1")->fetch();

if (!$poll) {
    die("No poll found.");
}

// Fetch poll options
$options = $pdo->prepare("SELECT option_text, votes FROM options WHERE poll_id = ?");
$options->execute([$poll['id']]);


// Fetch votes per option
$votes = $pdo->prepare("SELECT option_id, COUNT(*) as total FROM poll_votes WHERE poll_id = ? GROUP BY option_id");
$votes->execute([$poll['id']]);

$voteCounts = [];
foreach ($votes as $v) {
    $voteCounts[$v['option_id']] = $v['total'];
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Poll Results</title>
</head>
<body>
    <h2>Results: <?php echo htmlspecialchars($poll['question']); ?></h2>
    <ul>
  <?php while ($option = $options->fetch()): ?>
    <li>
        <?= htmlspecialchars($option['option_text']) ?> - <?= $option['votes'] ?> votes
    </li>
<?php endwhile; ?>

    </ul>
    <a href="../index.php">Back to Home</a>
</body>
</html>reportpage


<?php
session_start();
$user = $_POST['username'];
$pass = $_POST['password'];
if ($user === 'admin' && $pass === 'password') {
    $_SESSION['admin'] = true;
    header('Location: dashboard.php');
} else {
    echo "Invalid credentials";
}
?>adminpollauth