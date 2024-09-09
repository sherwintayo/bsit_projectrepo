<?php
require_once('../config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $new_password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    
    // Update the password in the database
    $stmt = $conn->prepare("UPDATE users SET password = ?, reset_token_hash = NULL, reset_token_expires_at = NULL WHERE id = ?");
    $stmt->bind_param('si', $new_password, $user_id);
    
    if ($stmt->execute()) {
        echo "Password has been reset successfully. <a href='login.php'>Login now</a>";
    } else {
        echo "Error resetting password.";
    }
}
?>
