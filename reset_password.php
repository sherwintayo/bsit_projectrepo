<?php
include('config.php');

$token = $_GET['token'] ?? '';

$sql = "SELECT * FROM password_resets WHERE token = ? AND expiry > NOW()";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Token is valid
    $validToken = true;
} else {
    // Token is invalid or expired
    $validToken = false;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <?php require_once('inc/header.php') ?>
</head>
<body>
    <div class="container">
        <?php if ($validToken): ?>
            <h2>Reset Password</h2>
            <form id="reset-password-form">
                <input type="hidden" name="token" value="<?= $token ?>">
                <div class="form-group">
                    <label for="password">New Password:</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Reset Password</button>
            </form>
        <?php else: ?>
            <h2>Invalid or Expired Token</h2>
        <?php endif; ?>
    </div>
    <script src="plugins/jquery/jquery.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#reset-password-form').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: 'reset_password_process.php',
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
