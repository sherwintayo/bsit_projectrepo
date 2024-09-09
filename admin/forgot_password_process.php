<?php
require_once('config.php');
require 'PHPMailer/PHPMailerAutoload.php'; // Include PHPMailer if not autoloaded

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = htmlspecialchars(trim($_POST['email']));

    // Fetch user with the provided email
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        // Generate a unique token and expiry time (e.g., 1 hour)
        $reset_token = bin2hex(random_bytes(32)); 
        $reset_token_hash = hash('sha256', $reset_token);
        $expires_at = date('Y-m-d H:i:s', strtotime('+1 hour'));

        // Store token and expiry in the database
        $update = $conn->prepare("UPDATE users SET reset_token_hash = ?, reset_token_expires_at = ? WHERE id = ?");
        $update->bind_param("ssi", $reset_token_hash, $expires_at, $user['id']);
        $update->execute();

        // Send password reset email
        $reset_link = base_url . "reset_password.php?token=$reset_token";
        send_reset_email($user['username'], $reset_link);

        echo "A password reset link has been sent to your email.";
    } else {
        echo "No account associated with this email.";
    }
}

function send_reset_email($email, $reset_link) {
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->Host = 'smtp.your-email-server.com'; // Set the SMTP server to send through
    $mail->SMTPAuth = true;
    $mail->Username = 'your-email@example.com'; // SMTP username
    $mail->Password = 'your-email-password'; // SMTP password
    $mail->SMTPSecure = 'tls'; 
    $mail->Port = 587; 

    $mail->setFrom('your-email@example.com', 'MCC Repositories');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = 'Password Reset Request';
    $mail->Body = "Click the link below to reset your password:<br><a href='$reset_link'>$reset_link</a>";

    if (!$mail->send()) {
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    } else {
        echo 'Password reset link sent!';
    }
}
?>
