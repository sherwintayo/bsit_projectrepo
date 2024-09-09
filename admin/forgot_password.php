<?php require_once('../config.php') ?>
<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
<!-- <?php require_once('inc/header.php') ?> -->
<body class="hold-transition ">
  <script>
    start_loader()
  </script>
  <style>
    html, body{
      height:calc(100%) !important;
      width:calc(100%) !important;
    }
    body {
        background: linear-gradient(135deg, #141e30 20%, #243b55 100%);
        background-size: cover;
        background-repeat: no-repeat;
        height: 100%;
        width: 100%;
    }
    .login-title{
      text-shadow: 3px 3px black;
      padding: 20px 0 0 0;
    }
    #logo-img{
        height:150px;
        width:150px;
        object-fit:scale-down;
        object-position:center center;
        border-radius:100%;
    }
    .myColor{
        background-image: linear-gradient(to right, #f83600 50%, #f9d423 150%);
    }
    .myLoginForm {
        background: transparent;
        border: 2px solid #f83600;
        backdrop-filter: blur(2px);
        border-radius: 20px 0 0 20px;
    }
    .btnLogin{
        border-radius: 0 20px 20px 0;
        border: 0;
        background-image: linear-gradient(to right, #f83600 50%, #f9d423 150%);
    }

    @media (max-width: 575.98px) {
        .myContainer {
            margin: 20px;
        }
        .login-form {
            width: 100%;
        }
        .card {
            width: 100%;
        }
        .myLoginForm {
            border-radius: 20px 20px 0 0;
        }
    }

    /* Small devices */
    @media (max-width: 767.98px) {  
        .myContainer {
            margin: 20px;
        }
        .login-form {
            width: 100%;
        }
        .card {
            width: 100%;
        }
    }

    /* Medium devices */
    @media (max-width: 991.98px) {
        .login-form {
            width: 70%;
        }
        .card {
            width: 90%;
        }
    }

    /* Large devices */
    @media (max-width: 1199.98px) {
        .login-form {
            width: 60%;
        }
        .card {
            width: 80%;
        }
    }

    /* Extra large devices */
    @media (min-width: 1200px) {
        .login-form {
            width: 50%;
        }
        .card {
            width: 70%;
        }
    }
  </style>

<div class="d-flex flex-column align-items-center w-100" id="forgot-password">
    <div class="body d-flex flex-column justify-content-center align-items-center">
        <div class="w-100">
            <h1 class="text-center py-5 my-5 login-title"><b><?php echo $_settings->info('name') ?></b></h1>
        </div> 
        <div class="row myContainer">
            <div class="myLoginForm col-lg-7 p-3 w-100 d-flex justify-content-center align-items-center text-navy">
                <div class="d-flex flex-column w-100 px-3">
                    <h1 class="text-center font-weight-bold text-white">Reset Password</h1>
                    <hr class="my-3" />
                    <form action="forgot_password_process.php" method="POST" id="forgot-password-form">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="input-group form-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-0"><i class="far fa-envelope fa-lg fa-fw"></i></span>
                                    </div>
                                    <input type="email" name="username" id="username" placeholder="Enter your email" class="form-control form-control-border" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">  
                            <div class="col-6">
                                <a class="text-light font-weight-bolder" href="<?php echo base_url ?>admin/login.php">Go Back</a>
                            </div>         
                            <div class="col-6">  
                                <div class="form-group text-right">
                                    <button class="btnLogin btn btn-primary btn-flat text-white" type="submit">Send Reset Link</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-5 d-flex flex-column justify-content-center myColor p-4">
                <h1 class="text-center font-weight-bold text-white">Password Assistance</h1>
                <hr class="my-3 bg-light myHr" />
                <p class="text-center font-weight-bolder text-light lead">Forgot your password? No worries! Enter your email to receive a password reset link.</p>
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
    $('#forgot_password_form').submit(function(e) {
    e.preventDefault();
    var email = $('#username').val();

    $.ajax({
        type: 'POST',
        url: 'forgot_password_process.php',
        data: { email: email },
        success: function(response) {
            var result = JSON.parse(response);
            if (result.status === 'success') {
                alert('Reset link sent to your email');
            } else {
                alert(result.msg);
            }
        }
    });
});

  });
</script>
</body>
</html>
