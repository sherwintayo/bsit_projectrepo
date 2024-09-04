<?php
require_once('../config.php');
session_start();

// Check if an error message is set in the session
$error_message = isset($_SESSION['error']) ? $_SESSION['error'] : '';
$attempts_left = isset($_SESSION['attempts']) ? 7 - $_SESSION['attempts'] : 7;
$locked_until = isset($_SESSION['locked']) ? $_SESSION['locked'] : 0;
?>

<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
<?php require_once('inc/header.php') ?>
<body class="hold-transition">
  <script>
    start_loader()
  </script>
  <style>
    html, body {
      height: calc(100%) !important;
      width: calc(100%) !important;
    }
    body {
      background-image: url("<?php echo validate_image($_settings->info('cover')) ?>");
      background-size: cover;
      background-repeat: no-repeat;
    }
    .login-title {
      text-shadow: 2px 2px black;
    }
    #login {
      flex-direction: column !important;
    }
    #logo-img {
      height: 70px;
      width: 70px;
      object-fit: scale-down;
      object-position: center center;
      border-radius: 50%;
    }
    #login .col-7, #login .col-5 {
      width: 100% !important;
      max-width: unset !important;
    }
    .attempt-message {
      color: red;
      text-align: center;
      margin-bottom: 20px;
    }
    .form-disabled {
      pointer-events: none;
      opacity: 0.5;
    }
  </style>
  <div class="h-100 d-flex align-items-center w-100" id="login">
    <div class="col-7 h-100 d-flex align-items-center justify-content-center">
      <div class="w-100">
        <h4 class="text-center py-5 login-title"><b><?php echo $_settings->info('name') ?> - Admin</b></h4>
      </div>
    </div>
    <div class="col-5 h-100 bg-gradient">
      <div class="row">
        <div class="myContainer-background d-flex w-100 h-100 justify-content-center align-items-center">
          <div class="card col-sm-12 col-md-6 col-lg-3 card-outline card-primary">
            <div class="card-header">
              <h4 class="text-white text-center"><b>Login</b></h4>
            </div>
            <div class="card-body">
              <?php if ($error_message): ?>
                <p class="attempt-message"><?php echo $error_message; ?></p>
              <?php endif; ?>

              <?php if ($attempts_left <= 3 && $attempts_left > 0): ?>
                <p class="attempt-message">You have <?php echo $attempts_left; ?> attempt(s) left to login.</p>
              <?php endif; ?>

              <?php if ($locked_until > time()): ?>
                <p class="attempt-message">
                  Too many login attempts. Please try again in <span id="countdown"></span> minutes.
                </p>
                <script>
                  var countdownDate = new Date(<?php echo $locked_until * 1000; ?>);
                  var countdownElement = document.getElementById("countdown");
                  var countdownInterval = setInterval(function() {
                    var now = new Date().getTime();
                    var distance = countdownDate - now;
                    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                    countdownElement.innerHTML = minutes + "m " + seconds + "s ";
                    if (distance < 0) {
                      clearInterval(countdownInterval);
                      location.reload();
                    }
                  }, 1000);
                </script>
                <style>
                  .form-disabled input[type="text"], .form-disabled input[type="password"], .form-disabled button[type="submit"] {
                    pointer-events: none;
                    opacity: 0.5;
                  }
                </style>
                <div class="form-disabled">
              <?php else: ?>
                <form id="login-frm" action="login_process.php" method="post">
                  <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                  <div class="input-group mb-3">
                    <input type="text" class="form-control" autofocus name="username" placeholder="Username">
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-user"></span>
                      </div>
                    </div>
                  </div>
                  <div class="input-group mb-3">
                    <input type="password" class="form-control" name="password" placeholder="Password">
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-8">
                      <a href="<?php echo base_url ?>">Go to Website</a>
                    </div>
                    <div class="col-4">
                      <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                    </div>
                  </div>
                </form>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

<script>
  $(document).ready(function(){
    end_loader();
  })
</script>
</body>
</html>
