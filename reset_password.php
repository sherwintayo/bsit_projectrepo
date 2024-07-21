<?php
require_once('./config.php');
require_once('./classes/DBConnection.php');
require_once('./classes/SystemSettings.php');

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $db = new DBConnection();
    $conn = $db->conn;

    $result = $conn->query("SELECT * FROM users WHERE reset_token = '$token' AND reset_token_expiry > NOW()");
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        $_SESSION['error'] = "Invalid or expired reset token.";
        header("Location: login.php");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
 <?php require_once('inc/header.php') ?>
<body class="hold-transition ">
  <script>
    start_loader()
  </script>
  <style>
    html, body{
      height:calc(100%) !important;
      width:calc(100%) !important;
    }
    body{
      background-image: url("<?php echo validate_image($_settings->info('cover')) ?>");
      background-size:cover;
      background-repeat:no-repeat;
    }
    .login-title{
      text-shadow: 2px 2px black
    }
    #login{
        direction:rtl
    }
    #login > *{
        direction:ltr
    }
    #logo-img{
        height:150px;
        width:150px;
        object-fit:scale-down;
        object-position:center center;
        border-radius:100%;
    }
  </style>
<div class="h-100 d-flex  align-items-center w-100" id="login">
    <div class="col-7 h-100 d-flex align-items-center justify-content-center">
      <div class="w-100">
        <center><img src="<?= validate_image($_settings->info('logo')) ?>" alt="" id="logo-img"></center>
        <h1 class="text-center py-5 login-title"><b><?php echo $_settings->info('name') ?> - Admin</b></h1>
      </div>
    </div>
    <div class="col-5 h-100 bg-gradient bg-navy">
        <div class="w-100 d-flex justify-content-center align-items-center h-100 text-navy">
            <div class="card card-outline card-primary rounded-0 shadow col-lg-10 col-md-10 col-sm-5">
                <div class="card-header">
                    <h5 class="card-title text-center text-dark"><b>Reset Password</b></h5>
                </div>
                <div class="card-body">
                    <form action="reset_password_handler.php" method="POST">
                        <input type="hidden" name="token" value="<?= $token ?>">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <input type="password" name="password" id="password" placeholder="New Password" class="form-control form-control-border" required>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" class="form-control form-control-border" required>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group text-right">
                                    <button class="btn btn-default bg-black btn-flat">Reset Password</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
