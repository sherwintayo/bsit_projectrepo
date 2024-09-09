<?php require_once('../config.php'); ?>
<!DOCTYPE html>
<html lang="en">
<!-- <?php require_once('inc/header.php') ?> -->
<body>
<div class="container">
    <h2>Forgot Password</h2>
    <form action="forgot_password_process.php" method="post">
        <div class="form-group">
            <label for="email">Enter your email address:</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Send Reset Link</button>
    </form>
</div>
</body>
</html>
