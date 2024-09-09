<?php
require_once('../config.php');
require_once('../vendor/autoload.php'); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    
    // Check if email exists in the users table
    $stmt = $conn->prepare("SELECT id, username FROM users WHERE username = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        // Generate reset token and expiration
        $token = bin2hex(random_bytes(32));
        $expires_at = date('Y-m-d H:i:s', strtotime('+1 hour'));
        $token_hash = hash('sha256', $token);
        
        // Store token and expiration in the database
        $stmt->bind_result($user_id, $username);
        $stmt->fetch();
        $update = $conn->prepare("UPDATE users SET reset_token_hash = ?, reset_token_expires_at = ? WHERE id = ?");
        $update->bind_param('ssi', $token_hash, $expires_at, $user_id);
        $update->execute();
        
        // Send the reset link via PHPMailer
        $reset_link = base_url . "admin/reset_password.php?token=$token";
        
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = 'smtp.example.com'; // SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'your_email@example.com';
        $mail->Password = 'your_password';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        
        $mail->setFrom('your_email@example.com', 'Your App Name');
        $mail->addAddress($email);
        $mail->isHTML(true);
        
        $mail->Subject = 'Password Reset Request';
        $mail->Body    = "Hi $username,<br><br>Click the link below to reset your password:<br><a href='$reset_link'>$reset_link</a><br><br>The link is valid for 1 hour.";
        
        if ($mail->send()) {
            echo "Reset link sent to your email.";
        } else {
            echo "Mailer Error: " . $mail->ErrorInfo;
        }
    } else {
        echo "Email not found.";
    }
}
?>
