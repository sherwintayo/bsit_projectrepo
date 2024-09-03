<?php 
require_once('../config.php'); 

// Initialize variables for error messages
$errors = [];
$attempts_left = 5 - $_SESSION['login_attempts'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check CSRF token
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        $errors[] = "Invalid CSRF token.";
    }

    // Rate limiting: Allow maximum 5 attempts within 15 minutes
    if ($_SESSION['login_attempts'] >= 5 && (time() - $_SESSION['last_login_attempt']) < 900) {
        $errors[] = "Too many login attempts. Please try again after 15 minutes.";
    } else {
        // Sanitize user inputs
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        if (empty($username) || empty($password)) {
            $errors[] = "Username and Password are required.";
        }

        if (empty($errors)) {
            // Use prepared statements to prevent SQL Injection
            $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
            if ($stmt) {
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows === 1) {
                    $user = $result->fetch_assoc();

                    // Verify password using password_verify
                    if (password_verify($password, $user['password'])) {
                        // Password is correct
                        // Regenerate session ID to prevent session fixation
                        session_regenerate_id(true);
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['username'] = $user['username'];

                        // Reset login attempts
                        $_SESSION['login_attempts'] = 0;
                        $_SESSION['last_login_attempt'] = time();

                        // Redirect to dashboard or desired page
                        redirect('dashboard.php');
                        exit();
                    } else {
                        $errors[] = "Invalid username or password.";
                    }
                } else {
                    $errors[] = "Invalid username or password.";
                }

                $stmt->close();
            } else {
                // Handle statement preparation error
                $errors[] = "An error occurred. Please try again later.";
            }

            // Increment login attempts
            $_SESSION['login_attempts'] += 1;
            $_SESSION['last_login_attempt'] = time();
            $attempts_left = 5 - $_SESSION['login_attempts'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en" style="height: auto;">
<?php require_once('inc/header.php') ?>
<body class="hold-transition">
  <script>
    start_loader()
  </script>
  <style>
    html, body{
      height:calc(100%) !important;
      width:calc(100%) !important;
    }
    body{
      background-image: url("<?php echo htmlspecialchars(validate_image($_settings->info('cover')), ENT_QUOTES, 'UTF-8') ?>");
      background-size:cover;
      background-repeat:no-repeat;
    }
    .login-title{
      text-shadow: 2px 2px black
    }
    #login{
      flex-direction:column !important
    }
    #logo-img{
        height:70px;
        width:70px;
        object-fit:scale-down;
        object-position:center center;
        border-radius:50%;
    }
    #login .col-7,#login .col-5{
      width: 100% !important;
      max-width:unset !important
    }
    .error-message {
        color: red;
        margin-bottom: 10px;
    }
    .warning-message {
        color: orange;
        margin-bottom: 10px;
    }
  </style>
  <div class="h-100 d-flex align-items-center w-100" id="login">
    <div class="col-7 h-100 d-flex align-items-center justify-content-center">
      <div class="w-100">
        <!-- <center><img src="<?= htmlspecialchars(validate_image($_settings->info('logo')), ENT_QUOTES, 'UTF-8') ?>" alt="" id="logo-img"></center> -->
        <h4 class="text-center py-5 login-title"><b><?php echo htmlspecialchars($_settings->info('name'), ENT_QUOTES, 'UTF-8') ?> - Admin</b></h4>
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
              <?php
              // Display error messages
              if (!empty($errors)) {
                  echo '<div class="error-message">';
                  foreach ($errors as $error) {
                      echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8') . '<br>';
                  }
                  echo '</div>';
              }

              // Display warning if the user has only 3 attempts left
              if ($attempts_left <= 3 && $attempts_left > 0) {
                  echo '<div class="warning-message">';
                  echo "You have $attempts_left attempts left.";
                  echo '</div>';
              }

              // If the user has exhausted their attempts
              if ($_SESSION['login_attempts'] >= 5 && (time() - $_SESSION['last_login_attempt']) < 900) {
                  $remaining_time = 900 - (time() - $_SESSION['last_login_attempt']);
                  echo '<div class="error-message">';
                  echo 'Too many login attempts. Please wait <span id="countdown"></span> minutes to try again.';
                  echo '</div>';
              }
              ?>
              <form id="login-frm" action="" method="post" autocomplete="off">
                <!-- CSRF Token -->
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">
                
                <div class="input-group mb-3">
                  <input type="text" class="form-control" id="username" name="username" placeholder="Username" required <?php if ($_SESSION['login_attempts'] >= 5 && (time() - $_SESSION['last_login_attempt']) < 900) echo 'disabled'; ?>>
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-user"></span>
                    </div>
                  </div>
                </div>
                <div class="input-group mb-3">
                  <input type="password" class="form-control" id="password" name="password" placeholder="Password" required <?php if ($_SESSION['login_attempts'] >= 5 && (time() - $_SESSION['last_login_attempt']) < 900) echo 'disabled'; ?>>
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-lock"></span>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-8">
                    <a href="<?php echo htmlspecialchars(base_url, ENT_QUOTES, 'UTF-8') ?>">Go to Website</a>
                  </div>
                  <!-- /.col -->
                  <div class="col-4">
                    <button type="submit" class="btn btn-primary btn-block" id="submit-btn" <?php if ($_SESSION['login_attempts'] >= 5 && (time() - $_SESSION['last_login_attempt']) < 900) echo 'disabled'; ?>>Sign In</button>
                  </div>
                  <!-- /.col -->
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
  $(document).ready(function(){
    end_loader();

    <?php if ($_SESSION['login_attempts'] >= 5 && (time() - $_SESSION['last_login_attempt']) < 900): ?>
        var timeLeft = <?php echo $remaining_time; ?>;
        var countdownElement = document.getElementById('countdown');

        var countdownTimer = setInterval(function(){
            var minutes = Math.floor(timeLeft / 60);
            var seconds = timeLeft % 60;
            countdownElement.textContent = minutes + "m " + (seconds < 10 ? '0' : '') + seconds + "s";

            if (timeLeft <= 0) {
                clearInterval(countdownTimer);
                location.reload();
            }

            timeLeft--;
        }, 1000);
    <?php endif; ?>
  })
</script>
</body>
</html>
