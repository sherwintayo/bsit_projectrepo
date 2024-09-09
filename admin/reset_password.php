<?php
require_once('../config.php');

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $token_hash = hash('sha256', $token);
    
    // Validate token
    $stmt = $conn->prepare("SELECT id, reset_token_expires_at FROM users WHERE reset_token_hash = ?");
    $stmt->bind_param('s', $token_hash);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $expires_at);
        $stmt->fetch();
        
        // Check if token has expired
        if (strtotime($expires_at) > time()) {
            // Token is valid
            echo "
            <form action='reset_password_process.php' method='post'>
                <input type='hidden' name='user_id' value='$user_id'>
                <div class='form-group'>
                    <label for='password'>New Password:</label>
                    <input type='password' name='password' id='password' class='form-control' required>
                </div>
                <button type='submit' class='btn btn-primary'>Reset Password</button>
            </form>";
        } else {
            echo "Token has expired.";
        }
    } else {
        echo "Invalid token.";
    }
} else {
    echo "No token provided.";
}
?>
