<?php require_once('../config.php') ?>

<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
<?php require_once('inc/header.php') ?>
<body class="hold-transition">
  <script>
    start_loader();
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
    .message {
      color: red;
      font-weight: bold;
      text-align: center;
      margin-bottom: 15px;
    }
    .countdown {
      color: red;
      font-weight: bold;
      text-align: center;
      margin-bottom: 15px;
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
              <div id="message-area"></div>
              <form id="login-frm" action="login_process.php" method="post">
                <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                <div class="input-group mb-3">
                  <input type="text" class="form-control" id="username" autofocus name="username" placeholder="Username">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-user"></span>
                    </div>
                  </div>
                </div>
                <div class="input-group mb-3">
                  <input type="password" class="form-control" id="password" name="password" placeholder="Password">
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
                    <button type="submit" id="submit-btn" class="btn btn-primary btn-block">Sign In</button>
                  </div>
                </div>
              </form>
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
  $(document).ready(function() {
    end_loader();

    // Handle login attempts
    const maxAttempts = 7;
    const lockoutTime = 5 * 60 * 1000; // 5 minutes in milliseconds
    const attemptsLeft = <?php echo isset($_SESSION['login_attempts']) ? maxAttempts - $_SESSION['login_attempts'] : maxAttempts; ?>;

    function displayMessage(message, isCountdown = false) {
      $('#message-area').html(`<div class="message">${message}</div>`);
      if (isCountdown) {
        $('#username, #password, #submit-btn').prop('disabled', true);
        setTimeout(() => {
          $('#username, #password, #submit-btn').prop('disabled', false);
          $('#message-area').html('');
        }, lockoutTime);
      } else {
        $('#username, #password, #submit-btn').prop('disabled', false);
      }
    }

    if (attemptsLeft <= 0) {
      displayMessage("You are temporarily locked out. Please try again later.", true);
    } else if (attemptsLeft <= 3) {
      displayMessage(`You have ${attemptsLeft} attempts left to login.`);
    }
  });
</script>
</body>
</html>
