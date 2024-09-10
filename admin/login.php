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
      background-position: center center;
    }
    body::before {
      background-color: rgba(0, 0, 0, 0.3);
      content: "";
      position: absolute;
      top: 0;
      right: 0;
      bottom: 0;
      left: 0;
    }
    .login-title {
      text-shadow: 3px 3px black;
      padding: 20px 0 0 0;
    }
    #logo-img {
      height: 150px;
      width: 150px;
      object-fit: scale-down;
      object-position: center center;
      border-radius: 100%;
    }
    .myColor {
      background-image: linear-gradient(to right, #f83600 50%, #f9d423 150%);
    }
    .myLoginForm {
      background: transparent;
      border: 2px solid #f83600;
      backdrop-filter: blur(4px);
      border-radius: 20px 0 0 20px;
    }
    .btnLogin {
      border-radius: 0 20px 20px 0;
      border: 0;
      background-image: linear-gradient(to right, #f83600 50%, #f9d423 150%);
    }
    .message, .countdown, #login-message {
      color: red;
      font-weight: bold;
      text-align: center;
      margin-bottom: 15px;
    }
    #login input[disabled] {
      background-color: #e9ecef;
    }

    /* Responsive adjustments */
    @media (max-width: 575.98px) {
      .myContainer {
        margin: 20px;
      }
      .myLoginForm {
        border-radius: 20px 20px 0 0;
      }
    }
    @media (max-width: 991.98px) {
      .login-form {
        width: 70%;
      }
    }
    @media (min-width: 1200px) {
      .login-form {
        width: 50%;
      }
    }
  </style>

  <div class="d-flex align-items-center w-100" id="login">
    <div class="body d-flex flex-column justify-content-center align-items-center">
      <div class="w-100">
        <h1 class="text-center py-5 my-5 login-title"><b><?php echo $_settings->info('name') ?> - Student</b></h1>
      </div>
      <div class="row myContainer">
        <div class="myLoginForm col-lg-7 p-3 w-100 d-flex justify-content-center align-items-center">
          <div class="d-flex flex-column w-100 px-3">
            <h1 class="text-center font-weight-bold text-white">Sign in to Account</h1>
            <hr class="my-3" />
            <form id="login-frm" action="login_process.php" method="post">
              <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
              <div class="row">
                      <div class="col-lg-12">
                        <div class="input-group form-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text rounded-0"><i class="far fa-envelope fa-lg fa-fw"></i></span>
                                </div>
                                    <input type="text" name="username" id="username" placeholder="Email" class="form-control form-control-border" required>
                                </div>
                            </div>
                      </div>
              <div class="row">
                   <div class="col-lg-12">
                     <div class="input-group form-group">
                      <div class="input-group-prepend">
                          <span class="input-group-text rounded-0"><i class="fas fa-key fa-lg fa-fw"></i></span>
                        </div>
                           <input type="password" name="password" id="password" placeholder="Password" class="form-control form-control-border" required>
                            </div>
                          </div>
                     </div>
              <div class="row">
                <div class="col-6">
                  <a class="text-white font-weight-bolder" href="<?php echo base_url ?>">Go Back</a>
                </div>
                <div class="col-6">
                  <div class="form-group text-right">
                    <button type="submit" id="login-btn" class="btnLogin btn btn-primary btn-flat text-white">Sign In</button>
                  </div>
                </div>
              </div>
              <div id="login-message"></div>
              <div class="row mt-2">
                <div class="col-lg-12 text-center">
                <a href="<?php echo base_url ?>admin/forgot_password.php" class="text-light">Forgot Password?</a>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="col-lg-5 d-flex flex-column justify-content-center myColor p-4">
          <h1 class="text-center font-weight-bold text-white">Hello Friends!</h1>
          <hr class="my-3 bg-light" />
          <p class="text-center font-weight-bolder text-light lead">Enter your personal details and start your journey with us!</p>
          <button class="btn btn-outline-light btn-lg align-self-center font-weight-bolder mt-4 myLinkBtn" onclick="location.href = 'forgot_password.php'">Sign Up</button>
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

      $('#login-frm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
          url: _base_url_+'admin/login_process.php',
          type: 'POST',
          data: $(this).serialize(),
          dataType: 'json',
          success: function(response) {
            if (response.status === 'locked') {
              $('#login-message').text('Too many login attempts. Please wait ' + (response.time / 60) + ' minutes.');
              $('#username, #password, #login-btn').prop('disabled', true);
              startCountdown(response.time);
            } else if (response.status === 'failed') {
              $('#login-message').text('You have ' + response.attempts_left + ' attempts left to login.');
            } else if (response.status === 'success') {
              window.location.href = 'dashboard.php';
            }
          }
        });
      });

      function startCountdown(seconds) {
        var countdown = seconds;
        var interval = setInterval(function() {
          $('#login-message').text('Too many login attempts. Please wait ' + Math.ceil(countdown / 60) + ' minutes.');
          countdown--;
          if (countdown <= 0) {
            clearInterval(interval);
            $('#login-message').text('');
            $('#username, #password, #login-btn').prop('disabled', false);
          }
        }, 1000);
      }
    });
  </script>
</body>
</html>
