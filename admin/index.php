<?php
// index.php
session_start();
ob_start(); // Ensures no output before headers

// Include login logic at the top
require_once 'login_query.php';
?>


<?php include ('head.php');?>

<body>
<?php include ('index_banner.php');?>
    <div class="container">
        <div class="row">

                    <center>
                        <i>Login As:</i>
                        <select onchange = "page(this.value)">
                            <option selected disables>System Admin</option>
                            <option value = "../admin2/index.php">System User</option>
                            <option value = "../login.php">Student Voter</option>
                    </select>

                    </center>
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">


                    <div class="form-heading">
                        <center>Admin Log in</center>
                    </div>
                    <div class="panel-body">
                        <form role="form" method = "post" enctype = "multipart/form-data">
                                <!-- <div class="form-group">
                                    <label for = "username" >Login ID</label>
                                        <input class="form-control" placeholder="Enter Login ID" name="login_id" type="text" autofocus>
                                </div> -->

                                <div class="form-group">
									<label for = "username" >Username</label>
										<input class="form-control" placeholder="Enter Username" name="username" type="text" autofocus>
                                </div>

 <div class="form-group" style="position: relative;">
    <label for="password">Password</label>
    <input class="form-control" placeholder="Enter Password" name="password" id="password" type="password" value="">
    <span toggle="#password" class="fa fa-eye-slash toggle-password" style="position: absolute; right: 15px; top: 38px; cursor: pointer;"></span>
</div>




                                <button class="btn btn-lg btn-success btn-block " name = "login">Login</a>

									<?php include ('login_query.php');?>
                        </form>
                    </div>
                </div>
            </div>

			 </div>
        </div>
    </div>
    <script type="text/javascript">
  function page (src) {
    window.location = src;
  }
  </script>

  <?php
  include ('script.php');
  include ('footer.php');
  ?>


<script>
  document.addEventListener("DOMContentLoaded", function () {
    const toggle = document.querySelector(".toggle-password");
    const password = document.querySelector("#password");

    toggle.addEventListener("click", function () {
      const type = password.getAttribute("type") === "password" ? "text" : "password";
      password.setAttribute("type", type);
      this.classList.toggle("fa-eye");
      this.classList.toggle("fa-eye-slash");
    });
  });
</script>


</body>

</html>
