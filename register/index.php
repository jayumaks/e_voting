<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
?>

<?php include('./head.php'); ?>
<body>
<?php include('./index_banner.php'); ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <!-- Flash Messages -->
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
            <?php endif; ?>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
            <?php endif; ?>

            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <h4>Voter Registration</h4>
                </div>
                <div class="panel-body">

                <!-- STEP 1: Enter Student ID -->
                <?php if (!isset($_SESSION['otp_verified']) && !isset($_SESSION['masked_email'])): ?>
                    <form method="post" action="send_otp.php">
                        <div class="form-group">
                            <label for="id_number">Student ID</label>
                            <input type="text" name="id_number" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Verify Email</button>
                    </form>
                <?php endif; ?>

                <!-- STEP 2: Enter OTP -->
                <?php if (isset($_SESSION['masked_email']) && !isset($_SESSION['otp_verified'])): ?>
                    <form method="post" action="verify_otp.php">
                        <input type="hidden" name="id_number" value="<?= $_SESSION['id_number']; ?>">
                        <p>An OTP has been sent to: <strong><?= $_SESSION['masked_email']; ?></strong></p>
                        <div class="form-group">
                            <label for="otp">Enter OTP</label>
                            <input type="text" name="otp" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-success btn-block">Verify OTP</button>
                        <a href="reset.php" class="btn btn-link btn-block text-center">Start Over</a>
                    </form>
                <?php endif; ?>

                <!-- STEP 3: Registration Form -->
                <?php if (isset($_SESSION['otp_verified']) && $_SESSION['otp_verified'] === true): ?>
                    <form method="post" action="register_save.php">
                        <input type="hidden" name="id_number" value="<?= $_SESSION['id_number']; ?>">
                        <input type="hidden" name="email" value="<?= $_SESSION['email']; ?>">

                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Retype Password</label>
                            <input type="password" name="password1" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" name="firstname" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" name="lastname" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Gender</label>
                            <select name="gender" class="form-control" required>
                                <option value="">-- Select --</option>
                                <option>Male</option>
                                <option>Female</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Department</label>
                            <input type="text" name="prog_study" class="form-control" placeholder="E.g. MCB, PYS, BCH..." required>
                        </div>

                        <div class="form-group">
                            <label>Year Level</label>
                            <select name="year_level" class="form-control" required>
                                <option value="">-- Select --</option>
                                <option>1st Year</option>
                                <option>2nd Year</option>
                                <option>3rd Year</option>
                                <option>4th Year</option>
                                <option>5th Year</option>
                            </select>
                        </div>

                        <button name="save" type="submit" class="btn btn-success btn-block">Complete Registration</button>
                        <a href="reset.php" class="btn btn-link btn-block text-center">Start Over</a>
                    </form>
                <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include('./footer.php'); ?>
</body>
</html>
