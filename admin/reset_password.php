<?php
require_once '../config.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $hashed_token = hash('sha256', $token);

    // Check if the token exists and is still valid
    $stmt = $conn->prepare("SELECT * FROM users WHERE reset_token_hash = ? AND reset_token_expires_at > NOW()");
    $stmt->bind_param("s", $hashed_token);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        // Display form to reset password
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $new_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $update = $conn->prepare("UPDATE users SET password = ?, reset_token_hash = NULL, reset_token_expires_at = NULL WHERE id = ?");
            $update->bind_param("si", $new_password, $user['id']);
            $update->execute();
            
            echo "Password reset successful. You can now <a href='login.php'>login</a>.";
        }
    } else {
        echo "Invalid or expired token.";
    }
} else {
    echo "Invalid request.";
}
?>
        <!DOCTYPE html>
        <html lang="en" class="" style="height: auto;">
        <!-- <?php require_once('inc/header.php') ?> -->
        <body class="hold-transition">
            <style>
                html, body {
                    height: calc(100%) !important;
                    width: calc(100%) !important;
                }
                body {
                    background: linear-gradient(135deg, #141e30 20%, #243b55 100%);
                    background-size: cover;
                    background-repeat: no-repeat;
                    height: 100%;
                    width: 100%;
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
                    backdrop-filter: blur(2px);
                    border-radius: 20px 0 0 20px;
                }
                .btnLogin {
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
            </style>

            <div class="d-flex flex-column align-items-center w-100" id="reset-password">
                <div class="body d-flex flex-column justify-content-center align-items-center">
                    <div class="w-100">
                        <h1 class="text-center py-5 my-5 login-title"><b><?php echo $_settings->info('name') ?></b></h1>
                    </div>
                    <div class="row myContainer">
                        <div class="myLoginForm col-lg-7 p-3 w-100 d-flex justify-content-center align-items-center text-navy">
                            <div class="d-flex flex-column w-100 px-3">
                                <h1 class="text-center font-weight-bold text-white">Reset Your Password</h1>
                                <hr class="my-3" />
                                <form action="" method="POST" >
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="input-group form-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text rounded-0"><i class="fas fa-lock fa-lg fa-fw"></i></span>
                                                </div>
                                                <input type="password" name="password" id="password" placeholder="Enter new password" class="form-control form-control-border" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <a class="text-light font-weight-bolder" href="<?php echo base_url ?>admin/login.php">Go Back</a>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group text-right">
                                                <button class="btnLogin btn btn-primary btn-flat text-white" type="submit">Reset Password</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-5 d-flex flex-column justify-content-center myColor p-4">
                            <h1 class="text-center font-weight-bold text-white">Password Assistance</h1>
                            <hr class="my-3 bg-light myHr" />
                            <p class="text-center font-weight-bolder text-light lead">Enter your new password and confirm to reset.</p>
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
                });
            </script>
        </body>
        </html>

