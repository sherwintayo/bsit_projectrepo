<?php
include('config.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <?php require_once('inc/header.php') ?>
</head>
<body>
    <div class="container">
        <h2>Forgot Password</h2>
        <form id="forgot-password-form">
            <div class="form-group">
                <label for="email">Enter your email address:</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Send Reset Link</button>
        </form>
    </div>
    <script src="plugins/jquery/jquery.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#forgot-password-form').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: 'forgot_password_process.php',
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    alert(response);
                }
            });
        });
    });
    </script>
</body>
</html>
