<?php
// index.php
session_start();
ob_start(); // Ensures no output before headers

// Include login logic at the top
require_once 'login_query.php';
?>


<?php include('head.php'); ?>

<body>
    <?php include('index_banner.php'); ?>
    <div class="container">
        <div class="row">

            <center>
                <i>Login As:</i>
                <select onchange="page(this.value)">
                    <option selected disables>System Admin</option>
                    <option value="../admin2/index.php">System User</option>
                    <option value="../login.php">Student Voter</option>
                </select>

            </center>
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">


                    <div class="form-heading">
                        <center>Admin Log in</center>
                    </div>
                    <div class="panel-body">
                        <form role="form" method="post" enctype="multipart/form-data">
                            <!-- <div class="form-group">
                                    <label for = "username" >Login ID</label>
                                        <input class="form-control" placeholder="Enter Login ID" name="login_id" type="text" autofocus>
                                </div> -->

                            <div class="form-group">
                                <label for="idno">Student ID:</label>
                                <input class="form-control" name="idno" type="text" required autofocus placeholder="Enter Student ID">
                            </div>

                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input class="form-control" name="password" id="password" type="password" required placeholder="Enter Password">
                            </div>

                            <div class="form-check mb-3">
                                <input type="checkbox" class="form-check-input" id="showPassword" onclick="togglePassword()">
                                <label class="form-check-label" for="showPassword">Show Password</label>
                            </div>

                            <script>
                                function togglePassword() {
                                    const pwd = document.getElementById("password");
                                    pwd.type = pwd.type === "password" ? "text" : "password";
                                }
                            </script>



                            <button class="btn btn-lg btn-success btn-block " name="login">Login</a>

                                <?php include('login_query.php'); ?>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>
    <script type="text/javascript">
        function page(src) {
            window.location = src;
        }
    </script>

    <?php
    include('script.php');
    include('footer.php');
    ?>

</body>

</html>