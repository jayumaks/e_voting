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



<?php
session_start(); // ✅ must be FIRST

if (!isset($_SESSION['voters_id'])) {
    header("Location: index.php");
    exit();
}

include('head.php');
include("sess.php"); // ✅ move after session_start
?>



<body>
	<?php include 'side_bar.php'; ?>
	<div id="wrapper">
	</div>
	<form method="POST" action="vote_result.php" style="margin-top: 60px;">
		<div class="col-lg-6">

			<div class="panel panel-primary">
				<div class="panel-heading">
					<center>
						PRESIDENT</center>
				</div>
				<div class="panel-body" style="background-color:; display:block;">
					<?php
					$query = $conn->query("SELECT * FROM `candidate` WHERE `position` = 'President'") or die(mysqli_errno());
					while ($fetch = $query->fetch_array()) {
					?>
						<div id="position">
							<center><img src="admin/<?php echo $fetch['img'] ?>" style="border-radius:6px;" height="150px" width="150px" class="img"></center>

							<center><?php echo "<strong>Names: </strong>" . $fetch['firstname'] . " " . $fetch['lastname'] . "<br/><strong>Gender: </strong> " . $fetch['gender'] . "<br/><strong>Level: </strong> " . $fetch['year_level'] . "<br/><strong>Party: </strong> " . $fetch['party'] ?></center>
							<center><input type="checkbox" value="<?php echo $fetch['candidate_id'] ?>" name="pres_id" class="pres">Give Vote</center>
						</div>

					<?php
					}
					?>

				</div>

			</div>
		</div>


		<div class="col-lg-6">

			<div class="panel panel-primary">
				<div class="panel-heading">
					<center>
						VICE PRESIDENT</center>
				</div>
				<div class="panel-body" style="background-color:;">
					<?php
					$query = $conn->query("SELECT * FROM `candidate` WHERE `position` = 'Vice President'") or die(mysqli_errno());
					while ($fetch = $query->fetch_array()) {
					?>
						<div id="position">
							<center><img class="image-rounded" src="admin/<?php echo $fetch['img'] ?>" style="border-radius:6px;" height="150px" width="150px"></center>
							<center><?php echo "<strong>Names: </strong>" . $fetch['firstname'] . " " . $fetch['lastname'] . "<br/><strong>Gender: </strong> " . $fetch['gender'] . "<br/><strong>Level: </strong> " . $fetch['year_level'] . "<br/><strong>Party: </strong> " . $fetch['party'] ?></center>
							<center><input type="checkbox" value="<?php echo $fetch['candidate_id'] ?>" name="vp_id" class="vpres">Give Vote</center>
						</div>
					<?php
					}
					?>

				</div>

			</div>
		</div>




		<div class="col-lg-6">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<center>Treasurer</center>
				</div>
				<div class="panel-body" style="background-color:;">
					<?php
					$query = $conn->query("SELECT * FROM `candidate` WHERE `position` = 'Treasurer'") or die(mysqli_errno());
					while ($fetch = $query->fetch_array()) {
					?>
						<div id="position">
							<center><img src="admin/<?php echo $fetch['img'] ?>" style="border-radius:6px;" height="150px" width="150px" class="img"></center>
							<center><?php echo "<strong>Names: </strong>" . $fetch['firstname'] . " " . $fetch['lastname'] . "<br/><strong>Gender: </strong> " . $fetch['gender'] . "<br/><strong>Level: </strong> " . $fetch['year_level'] . "<br/><strong>Party: </strong> " . $fetch['party'] ?></center>
							<center><input type="checkbox" value="<?php echo $fetch['candidate_id'] ?>" name="treasurer_id" class="treasurer">Give Vote</center>
						</div>

					<?php
					}
					?>
				</div>
			</div>
		</div>

		<div class="col-lg-6">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<center>Secretary General</center>
				</div>
				<div class="panel-body" style="background-color:;">
					<?php
					$query = $conn->query("SELECT * FROM `candidate` WHERE `position` = 'Secretary General'") or die(mysqli_errno());
					while ($fetch = $query->fetch_array()) {
					?>
						<div id="position">
							<center><img src="admin/<?php echo $fetch['img'] ?>" style="border-radius:6px;" height="150px" width="150px" class="img"></center>
							<center><?php echo "<strong>Names: </strong>" . $fetch['firstname'] . " " . $fetch['lastname'] . "<br/><strong>Gender: </strong> " . $fetch['gender'] . "<br/><strong>Level: </strong> " . $fetch['year_level'] . "<br/><strong>Party: </strong> " . $fetch['party'] ?></center>
							<center><input type="checkbox" value="<?php echo $fetch['candidate_id'] ?>" name="sg_id" class="sg">Give Vote</center>
						</div>

					<?php
					}
					?>
				</div>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<center>Welfare</center>
				</div>
				<div class="panel-body" style="background-color:;">
					<?php
					$query = $conn->query("SELECT * FROM `candidate` WHERE `position` = 'Welfare'") or die(mysqli_errno());
					while ($fetch = $query->fetch_array()) {
					?>
						<div id="position">
							<center><img src="admin/<?php echo $fetch['img'] ?>" style="border-radius:6px;" height="150px" width="150px" class="img"></center>
							<center><?php echo "<strong>Names: </strong>" . $fetch['firstname'] . " " . $fetch['lastname'] . "<br/><strong>Gender: </strong> " . $fetch['gender'] . "<br/><strong>Level: </strong> " . $fetch['year_level'] . "<br/><strong>Party: </strong> " . $fetch['party'] ?></center>
							<center><input type="checkbox" value="<?php echo $fetch['candidate_id'] ?>" name="tas_id" class="tas">Give Vote</center>
						</div>

					<?php
					}
					?>
				</div>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<center>PRO</center>
				</div>
				<div class="panel-body" style="background-color:;">
					<?php
					$query = $conn->query("SELECT * FROM `candidate` WHERE `position` = 'Publicity Secretary'") or die(mysqli_errno());
					while ($fetch = $query->fetch_array()) {
					?>
						<div id="position">
							<center><img src="admin/<?php echo $fetch['img'] ?>" style="border-radius:6px;" height="150px" width="150px" class="img"></center>
							<center><?php echo "<strong>Names: </strong>" . $fetch['firstname'] . " " . $fetch['lastname'] . "<br/><strong>Gender: </strong> " . $fetch['gender'] . "<br/><strong>Level: </strong> " . $fetch['year_level'] . "<br/><strong>Party: </strong> " . $fetch['party'] ?></center>
							<center><input type="checkbox" value="<?php echo $fetch['candidate_id'] ?>" name="ps_id" class="ps">Give Vote</center>
						</div>

					<?php
					}
					?>
				</div>
			</div>
		</div>





		<hr />

		<center><button class="btn btn-success ballot" type="submit" name="submit">Submit Ballot</button></center>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	</form>
</body>
<?php include('script.php');
include('footer.php'); ?>

<script type="text/javascript">
	$(document).ready(function() {
		$(".pres").on("change", function() {
			if ($(".pres:checked").length == 1) {
				$(".pres").attr("disabled", "disabled");
				$(".pres:checked").removeAttr("disabled");
			} else {
				$(".pres").removeAttr("disabled");
			}
		});

		$(".vpres").on("change", function() {
			if ($(".vpres:checked").length == 1) {
				$(".vpres").attr("disabled", "disabled");
				$(".vpres:checked").removeAttr("disabled");
			} else {
				$(".vpres").removeAttr("disabled");
			}
		});

		$(".ua").on("change", function() {
			if ($(".ua:checked").length == 1) {
				$(".ua").attr("disabled", "disabled");
				$(".ua:checked").removeAttr("disabled");
			} else {
				$(".ua").removeAttr("disabled");
			}
		});

		$(".ss").on("change", function() {
			if ($(".ss:checked").length == 1) {
				$(".ss").attr("disabled", "disabled");
				$(".ss:checked").removeAttr("disabled");
			} else {
				$(".ss").removeAttr("disabled");
			}
		});

		$(".ea").on("change", function() {
			if ($(".ea:checked").length == 1) {
				$(".ea").attr("disabled", "disabled");
				$(".ea:checked").removeAttr("disabled");
			} else {
				$(".ea").removeAttr("disabled");
			}
		});

		$(".treasurer").on("change", function() {
			if ($(".treasurer:checked").length == 1) {
				$(".treasurer").attr("disabled", "disabled");
				$(".treasurer:checked").removeAttr("disabled");
			} else {
				$(".treasurer").removeAttr("disabled");
			}

		});
		$(".vtr").on("change", function() {
			if ($(".vtr:checked").length == 1) {
				$(".vtr").attr("disabled", "disabled");
				$(".vtr:checked").removeAttr("disabled");
			} else {
				$(".vtr").removeAttr("disabled");
			}
		});
		$(".sg").on("change", function() {
			if ($(".sg:checked").length == 1) {
				$(".sg").attr("disabled", "disabled");
				$(".sg:checked").removeAttr("disabled");
			} else {
				$(".sg").removeAttr("disabled");
			}
		});
		$(".tas").on("change", function() {
			if ($(".tas:checked").length == 1) {
				$(".tas").attr("disabled", "disabled");
				$(".tas:checked").removeAttr("disabled");
			} else {
				$(".tas").removeAttr("disabled");
			}
		});
		$(".ps").on("change", function() {
			if ($(".ps:checked").length == 1) {
				$(".ps").attr("disabled", "disabled");
				$(".ps:checked").removeAttr("disabled");
			} else {
				$(".ps").removeAttr("disabled");
			}
		});
		$(".as").on("change", function() {
			if ($(".as:checked").length == 1) {
				$(".as").attr("disabled", "disabled");
				$(".as:checked").removeAttr("disabled");
			} else {
				$(".as").removeAttr("disabled");
			}
		});
	});
</script>

</html vote.php code here>



<?php
session_start();
ob_start();
include ('head.php');
?>

<body>
<?php include ('view_banner.php'); ?>

<style>
  .login-container {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-top: 40px;
    padding: 20px;
  }

  .login-panel {
    background: #ffffff;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    padding: 20px;
    width: 100%;
    max-width: 400px;
  }

  .form-heading {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 20px;
    color: #003366;
  }

  .form-field {
    margin-bottom: 20px;
  }

  .form-panel select {
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
    width: 100%;
    margin-top: 10px;
  }

  .btn-success {
    background-color: #003366;
    border-color: #003366;
    color: white;
  }

  .btn-success:hover {
    background-color: #0055aa;
    border-color: #0055aa;
  }

  .btn-block {
    width: 100%;
    margin-bottom: 10px;
  }

  @media (max-width: 500px) {
    .login-panel {
      padding: 20px;
    }
    .form-heading {
      font-size: 20px;
    }
  }
</style>

<div class="login-container">
  <div class="login-panel">
    <div class="form-panel">
      <div style="text-align: center;">
        <label style="font-style: italic;">Login As:</label>
        <select onchange="page(this.value)">
          <option value="admin/index.php">System Admin</option>
          <option value="admin2/index.php">System User</option>
          <option selected disabled>Student Voter</option>
        </select>
      </div>

      <!-- Display Error Message if exists -->
      <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger text-center">
          <?= $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
      <?php endif; ?>

      <form role="form" method="post" enctype="multipart/form-data" class="index-form">
        <div class="form-heading text-center">Student Login</div>

        <div class="form-field">
          <label for="idno">Student ID:</label>
          <input class="form-control" placeholder="Enter Student ID" name="idno" type="text" required autofocus>
        </div>

        <div class="form-field">
          <label for="password">Password:</label>
          <input class="form-control" placeholder="Enter Password" name="password" type="password" required>
        </div>

        <div style="text-align: center;">
          <button class="btn btn-lg btn-success btn-block" name="login">Login</button>
          <a href="register/index.php" class="btn btn-lg btn-success btn-block" style="margin-top: 10px;">Register</a>
        </div>

        <?php include('login_query.php'); ?>
      </form>
    </div>
  </div>
</div>

<?php include ('script.php'); ?>

<script type="text/javascript">
  function page(src) {
    window.location = src;
  }
</script>

<?php include ('footer.php'); ?>
</body>
</html  login.php>


<?php include ('head.php');?>
<?php include ('sess.php');?>

<body>
<?php include 'side_bar.php'; ?>
    <div id="row">
        <?php
			if(ISSET($_POST['submit']))
				{
					if(!ISSET($_POST['pres_id']))
					{
						$_SESSION['pres_id'] = "";
					}
					else
					{
						$_SESSION['pres_id'] = $_POST['pres_id'];
					}
					if(!ISSET($_POST['vp_id']))
					{
						$_SESSION['vp_id'] = "";
					}
					else
					{
						$_SESSION['vp_id'] = $_POST['vp_id'];
					}
					if(!ISSET($_POST['ua_id']))
					{
						$_SESSION['ua_id'] = "";
					}
					else
					{
						$_SESSION['ua_id'] = $_POST['ua_id'];
					}
					if(!ISSET($_POST['ss_id']))
					{
						$_SESSION['ss_id'] = "";
					}
					else
					{
						$_SESSION['ss_id'] = $_POST['ss_id'];
					}
					if(!ISSET($_POST['ea_id']))
					{
						$_SESSION['ea_id'] = "";
					}
					else
					{
						$_SESSION['ea_id'] = $_POST['ea_id'];
					}
					if(!ISSET($_POST['treasurer_id']))
					{
						$_SESSION['treasurer_id'] = "";
					}
					else
					{
						$_SESSION['treasurer_id'] = $_POST['treasurer_id'];
					}
					if(!ISSET($_POST['sg_id']))
					{
						$_SESSION['sg_id'] = "";
					}
					else
					{
						$_SESSION['sg_id'] = $_POST['sg_id'];
					}
					if(!ISSET($_POST['vtr_id']))
					{
						$_SESSION['vtr_id'] = "";
					}
					else
					{
						$_SESSION['vtr_id'] = $_POST['vtr_id'];
					}
					if(!ISSET($_POST['tas_id']))
					{
						$_SESSION['tas_id'] = "";
					}
					else
					{
						$_SESSION['tas_id'] = $_POST['tas_id'];
					}
					if(!ISSET($_POST['ps_id']))
					{
						$_SESSION['ps_id'] = "";
					}
					else
					{
						$_SESSION['ps_id'] = $_POST['ps_id'];
					}
					if(!ISSET($_POST['as_id']))
					{
						$_SESSION['as_id'] = "";
					}
					else
					{
						$_SESSION['as_id'] = $_POST['as_id'];
					}
				}
		?>
    </div>
			<center>
		  <div class="col-lg-8" style = "margin-left:25%; margin-right:25%;" >
		  <div class = "alert alert-info">
			<div class="panel-heading"><center>PRESIDENT</center></div>
			<br />
			<?php
				if(!$_SESSION['pres_id'])
					{

					}
				else
					{
						$fetch = $conn->query("SELECT * FROM `candidate` WHERE `candidate_id` = '$_SESSION[pres_id]'")->fetch_array();

						echo $fetch['firstname']." ".$fetch['lastname']." "."<img src = 'admin/".$fetch['img']."' style = 'height:80px; width:80px; border-radius:500px;' />";
					}
			?>
			</div>
			<div class = "alert alert-success" >
			<div class="panel-heading"><center>VICE PRESIDENT</center></div>
			<br />
			<?php
				if(!$_SESSION['vp_id'])
					{

					}
				else
					{
						$fetch = $conn->query("SELECT * FROM `candidate` WHERE `candidate_id` = '$_SESSION[vp_id]'")->fetch_array();
						echo $fetch['firstname']." ".$fetch['lastname']." "."<img src = 'admin/".$fetch['img']."' style = 'height:80px; width:80px; border-radius:500px;' />";
					}
			?>
			</div>
			<!-- <div class = "alert alert-info">
			<div class="panel-heading"><center>UNION ADVISOR</center></div>
			<br/>
			<?php
				if(!$_SESSION['ua_id'])
					{

					}
				else
					{
						$fetch = $conn->query("SELECT * FROM `candidate` WHERE `candidate_id` = '$_SESSION[ua_id]'")->fetch_array();
						echo $fetch['firstname']." ".$fetch['lastname']." "."<img src = 'admin/".$fetch['img']."' style = 'height:80px; width:80px; border-radius:500px;' />";
					}
			?>

			</div> -->
			<!-- <div class = "alert alert-success" >
			<div class="panel-heading"><center>SPORTS SECRETARY</center></div>
			<br />
			<?php
				if(!$_SESSION['ss_id'])
					{

					}
				else
					{
						$fetch = $conn->query("SELECT * FROM `candidate` WHERE `candidate_id` = '$_SESSION[ss_id]'")->fetch_array();
						echo $fetch['firstname']." ".$fetch['lastname']." "."<img src = 'admin/".$fetch['img']."' style = 'height:80px; width:80px; border-radius:500px;' />";
					}
			?>

			</div> -->
			<!-- <div class = "alert alert-info">

			<div class="panel-heading"><center>ENTERTAINMENT ADVISOR</center></div>
			<br />
			<?php
				if(!$_SESSION['ea_id'])
					{

					}
				else
					{
						$fetch = $conn->query("SELECT * FROM `candidate` WHERE `candidate_id` = '$_SESSION[ea_id]'")->fetch_array();
						echo $fetch['firstname']." ".$fetch['lastname']." "."<img src = 'admin/".$fetch['img']."' style = 'height:80px; width:80px; border-radius:500px;' />";
					}
			?>

			</div> -->
			<div class = "alert alert-success">
			<div class="panel-heading"><center>TREASURER</center></div>
			<br />
			<?php
				if(!$_SESSION['treasurer_id'])
					{

					}
				else
					{
						$fetch = $conn->query("SELECT * FROM `candidate` WHERE `candidate_id` = '$_SESSION[treasurer_id]'")->fetch_array();
						echo $fetch['firstname']." ".$fetch['lastname']." "."<img src = 'admin/".$fetch['img']."' style = 'height:80px; width:80px; border-radius:500px;' />";
					}
			?>

			</div>
			<div class = "alert alert-info" >
			<div class="panel-heading"><center>SECRETARY GENERAL</center></div>
			<br />
			<?php
				if(!$_SESSION['sg_id'])
					{

					}
				else
					{
						$fetch = $conn->query("SELECT * FROM `candidate` WHERE `candidate_id` = '$_SESSION[sg_id]'")->fetch_array();
						echo $fetch['firstname']." ".$fetch['lastname']." "."<img src = 'admin/".$fetch['img']."' style = 'height:80px; width:80px; border-radius:500px;' />";
					}
			?>
			</div>
			<!-- <div class = "alert alert-success">
			<div class="panel-heading"><center>VICE TREASURER</center></div>
			<br />
			<?php
				if(!$_SESSION['vtr_id'])
					{

					}
				else
					{
						$fetch = $conn->query("SELECT * FROM `candidate` WHERE `candidate_id` = '$_SESSION[vtr_id]'")->fetch_array();
						echo $fetch['firstname']." ".$fetch['lastname']." "."<img src = 'admin/".$fetch['img']."' style = 'height:80px; width:80px; border-radius:500px;' />";
					}
			?>

			</div> -->
			<div class = "alert alert-info">
			<div class="panel-heading"><center>Welfare</center></div>
			<br />
			<?php
				if(!$_SESSION['tas_id'])
					{

					}
				else
					{
						$fetch = $conn->query("SELECT * FROM `candidate` WHERE `candidate_id` = '$_SESSION[tas_id]'")->fetch_array();
						echo $fetch['firstname']." ".$fetch['lastname']." "."<img src = 'admin/".$fetch['img']."' style = 'height:80px; width:80px; border-radius:500px;' />";
					}
			?>

			</div>
			<div class = "alert alert-success">
			<div class="panel-heading"><center>PUBLICITY SECRETARY</center></div>
			<br />
			<?php
				if(!$_SESSION['ps_id'])
					{

					}
				else
					{
						$fetch = $conn->query("SELECT * FROM `candidate` WHERE `candidate_id` = '$_SESSION[ps_id]'")->fetch_array();
						echo $fetch['firstname']." ".$fetch['lastname']." "."<img src = 'admin/".$fetch['img']."' style = 'height:80px; width:80px; border-radius:500px;' />";
					}
			?>

			</div>
			<!-- <div class = "alert alert-info">
			<div class="panel-heading"><center>ACADEMICS SECRETARY</center></div>
			<br />
			<?php
				if(!$_SESSION['as_id'])
					{

					}
				else
					{
						$fetch = $conn->query("SELECT * FROM `candidate` WHERE `candidate_id` = '$_SESSION[as_id]'")->fetch_array();
						echo $fetch['firstname']." ".$fetch['lastname']." "."<img src = 'admin/".$fetch['img']."' style = 'height:80px; width:80px; border-radius:500px;' />";
					}
			?>

			</div> -->
			<br />
			</div>
	</center>
                                    <div class="modal-body">
										<p><center>Are you sure you want to submit your Votes? </center></p>
                                    </div>

									<div class="modal-footer"><center>
								<a href = "submit_vote.php"><button type = "submit" class="btn btn-success"><i class="icon-check"></i>&nbsp;Yes</button></a>
								<a href = "vote.php"><button class="btn btn-danger" aria-hidden="true"><i class="icon-remove icon-large"></i>&nbsp;Back</button></a>
									</center></div>
                                    <!-- /.modal-content -->

                                <!-- /.modal-dialog -->


</body>

<?php include ('script.php');
include ('footer.php');?>
</html  vote_result.php>


<?php
	include("admin/dbcon.php");
	session_start();
	session_destroy();
		$conn->query("INSERT INTO `votes` VALUES('', '$_SESSION[pres_id]', '$_SESSION[voters_id]')") or die($conn->error);
		$conn->query("INSERT INTO `votes` VALUES('', '$_SESSION[vp_id]', '$_SESSION[voters_id]')") or die($conn->error);
		$conn->query("INSERT INTO `votes` VALUES('', '$_SESSION[ua_id]', '$_SESSION[voters_id]')") or die($conn->error);
		$conn->query("INSERT INTO `votes` VALUES('', '$_SESSION[ss_id]', '$_SESSION[voters_id]')") or die($conn->error);
		$conn->query("INSERT INTO `votes` VALUES('', '$_SESSION[ea_id]', '$_SESSION[voters_id]')") or die($conn->error);
		$conn->query("INSERT INTO `votes` VALUES('', '$_SESSION[treasurer_id]', '$_SESSION[voters_id]')") or die($conn->error);
		$conn->query("INSERT INTO `votes` VALUES('', '$_SESSION[sg_id]', '$_SESSION[voters_id]')") or die($conn->error);
		$conn->query("INSERT INTO `votes` VALUES('', '$_SESSION[vtr_id]', '$_SESSION[voters_id]')") or die($conn->error);
		$conn->query("INSERT INTO `votes` VALUES('', '$_SESSION[tas_id]', '$_SESSION[voters_id]')") or die($conn->error);
		$conn->query("INSERT INTO `votes` VALUES('', '$_SESSION[ps_id]', '$_SESSION[voters_id]')") or die($conn->error);
		$conn->query("INSERT INTO `votes` VALUES('', '$_SESSION[as_id]', '$_SESSION[voters_id]')") or die($conn->error);
		$conn->query("UPDATE `voters` SET `status` = 'Voted' WHERE `voters_id` = '$_SESSION[voters_id]'") or die($conn->error);
		header("location:index.php");

? submit_vote.php>


<?php include ('session.php');?>
<?php include ('head.php');?>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include ('side_bar.php');?>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">


                </div>


				<hr/>

                    <div class="panel panel-default">
                        <div class="panel-heading">
							<h4 class = "alert alert-success">Election Report</h4>
                        </div>

					<br/>
                       <form method="post" action="sort.php">

			<select name="position" id="position" class = "form-control pull-left" style = "width:300px;margin-left:19px; ">
				<option readonly>----Sort by Position----</option>
				<option></option>
								<option>President</option>
								<option>Vice President</option>

								<option>Treasurer</option>
								<option>Secretary General</option>

								<option>Welfare</option>
								<option>PRO</option>


			</select>

			&nbsp;
			&nbsp;
			<button id ="sort" class = "btn btn-success">Sort</button><button type="button" onclick="window.print();" style = "margin-right:14px;" id ="print" class = "pull-right btn btn-info"><i class = "fa fa-print"></i> Print</button>
			<a href="excel.php"><button type="button" style = "margin-right:14px;" id ="print" class = "pull-right btn btn-info"><i class = "fa fa-print"></i>Export to Excel</button></a>

</form>
                        <div class="panel-body">


			<table class="table table-striped table-bordered table-hover ">
					<thead>
						<td style = "width:600px;" class = "alert alert-success">Candidate for President</td>
						<td style = "width:200px;"class = "alert alert-success">Image</td>
						<td class = "alert alert-success">Total</td>

					</thead>
					<?php
		require 'dbcon.php';
			$query = $conn->query("SELECT * FROM candidate WHERE position = 'President'");
		while($fetch = $query->fetch_array())
		{
			$id = $fetch['candidate_id'];
			$query1 = $conn->query("SELECT COUNT(*) as total FROM `votes` WHERE candidate_id = '$id'");
			$fetch1 = $query1->fetch_assoc();

	?>
					<tbody>
						<td><?php echo $fetch ['firstname']. " ".$fetch ['lastname'];?></td>
						<td><img src = "<?php echo $fetch ['img'];?>" style = "width:40px; height:40px; border-radius:500px; " >
						<td style = "width:20px; text-align:center"><button class = "btn btn-primary"disabled><?php echo $fetch1 ['total'];?></button>	</td>
					<?php }?>
					</tbody>


			</table>



			<table class="table table-striped table-bordered table-hover ">
					<thead>
						<td style = "width:600px;"class = "alert alert-success">Candidate for Vice President</td>
						<td style = "width:200px;" class = "alert alert-success">Image</td>
						<td class = "alert alert-success">Total</td>

					</thead>
					<?php
			require 'dbcon.php';
			$query = $conn->query("SELECT * FROM candidate WHERE position = 'Vice President'");
		while($fetch = $query->fetch_array())
		{
			$id = $fetch['candidate_id'];
			$query1 = $conn->query("SELECT COUNT(*) as total FROM `votes` WHERE candidate_id = '$id'");
			$fetch1 = $query1->fetch_assoc();

	?>
					<tbody>
						<td><?php echo $fetch ['firstname']. " ".$fetch ['lastname'];?></td>
						<td><img src = "<?php echo $fetch ['img'];?>" style = "width:40px; height:40px; border-radius:500px; " >
						<td style = "width:20px; text-align:center"><button class = "btn btn-primary"disabled><?php echo $fetch1 ['total'];?></button>	</td>
					<?php }?>
					</tbody>


			</table>



			<table class="table table-striped table-bordered table-hover ">
					<thead>
						<td style = "width:600px;"class = "alert alert-success">Candidate for Treasurer</td>
						<td style = "width:200px;" class = "alert alert-success">Image</td>
						<td class = "alert alert-success">Total</td>

					</thead>
					<?php
		require 'dbcon.php';
		$query = $conn->query("SELECT * FROM candidate WHERE position = 'Treasurer'");
		while($fetch = $query->fetch_array())
		{
			$id = $fetch['candidate_id'];
			$query1 = $conn->query("SELECT COUNT(*) as total FROM `votes` WHERE candidate_id = '$id'");
			$fetch1 = $query1->fetch_assoc();

	?>
					<tbody>
						<td><?php echo $fetch ['firstname']. " ".$fetch ['lastname'];?></td>
						<td><img src = "<?php echo $fetch ['img'];?>" style = "width:40px; height:40px; border-radius:500px; " >
						<td style = "width:20px; text-align:center"><button class = "btn btn-primary"disabled><?php echo $fetch1 ['total'];?></button>	</td>
					<?php }?>
					</tbody>


			</table>



			<table class="table table-striped table-bordered table-hover ">
					<thead>
						<td style = "width:600px;"class = "alert alert-success">Candidate for Secretary General</td>
						<td style = "width:200px;" class = "alert alert-success">Image</td>
						<td class = "alert alert-success">Total</td>

					</thead>
					<?php
		require 'dbcon.php';
		$query = $conn->query("SELECT * FROM candidate WHERE position = 'Secretary General'");
		while($fetch = $query->fetch_array())
		{
			$id = $fetch['candidate_id'];
			$query1 = $conn->query("SELECT COUNT(*) as total FROM `votes` WHERE candidate_id = '$id'");
			$fetch1 = $query1->fetch_assoc();

	?>
					<tbody>
						<td><?php echo $fetch ['firstname']. " ".$fetch ['lastname'];?></td>
						<td><img src = "<?php echo $fetch ['img'];?>" style = "width:40px; height:40px; border-radius:500px; " >
						<td style = "width:20px; text-align:center"><button class = "btn btn-primary"disabled><?php echo $fetch1 ['total'];?></button>	</td>
					<?php }?>
					</tbody>


			</table>





			<table class="table table-striped table-bordered table-hover ">
					<thead>
						<td style = "width:600px;"class = "alert alert-success">Candidate for Welfare Secretary</td>
						<td style = "width:200px;" class = "alert alert-success">Image</td>
						<td class = "alert alert-success">Total</td>

					</thead>
					<?php
		require 'dbcon.php';
		$query = $conn->query("SELECT * FROM candidate WHERE position = 'Welfare'");
		while($fetch = $query->fetch_array())
		{
			$id = $fetch['candidate_id'];
			$query1 = $conn->query("SELECT COUNT(*) as total FROM `votes` WHERE candidate_id = '$id'");
			$fetch1 = $query1->fetch_assoc();

	?>
					<tbody>
						<td><?php echo $fetch ['firstname']. " ".$fetch ['lastname'];?></td>
						<td><img src = "<?php echo $fetch ['img'];?>" style = "width:40px; height:40px; border-radius:500px; " >
						<td style = "width:20px; text-align:center"><button class = "btn btn-primary"disabled><?php echo $fetch1 ['total'];?></button>	</td>
					<?php }?>
					</tbody>


			</table>


			<table class="table table-striped table-bordered table-hover ">
					<thead>
						<td style = "width:600px;"class = "alert alert-success">Candidate for Publicity Secretary</td>
						<td style = "width:200px;" class = "alert alert-success">Image</td>
						<td class = "alert alert-success">Total</td>

					</thead>
					<?php
		require 'dbcon.php';
		$query = $conn->query("SELECT * FROM candidate WHERE position = 'Publicity Secretary'");
		while($fetch = $query->fetch_array())
		{
			$id = $fetch['candidate_id'];
			$query1 = $conn->query("SELECT COUNT(*) as total FROM `votes` WHERE candidate_id = '$id'");
			$fetch1 = $query1->fetch_assoc();

	?>
					<tbody>
						<td><?php echo $fetch ['firstname']. " ".$fetch ['lastname'];?></td>
						<td><img src = "<?php echo $fetch ['img'];?>" style = "width:40px; height:40px; border-radius:500px; " >
						<td style = "width:20px; text-align:center"><button class = "btn btn-primary"disabled><?php echo $fetch1 ['total'];?></button>	</td>
					<?php }?>
					</tbody>


			</table>















							</div>
		    </div>
                            <!-- /.table-responsive -->

                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->

            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->



    </div>
    <!-- /#wrapper -->

    <?php include ('script.php');?>

</body>

</html  canvassing.php>


