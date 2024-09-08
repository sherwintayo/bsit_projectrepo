<?php
require 'vendor/autoload.php';  // PHPMailer

function send_password_reset($email, $reset_link) {
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';  // Specify mail server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'your-email@gmail.com';  // SMTP username
        $mail->Password   = 'your-email-password';  // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  
        $mail->Port       = 587;  // TCP port to connect to

        // Recipients
        $mail->setFrom('your-email@gmail.com', 'Project Repositories');
        $mail->addAddress($email);  // Add the recipient

        // Content
        $mail->isHTML(true);  // Set email format to HTML
        $mail->Subject = 'Password Reset Request';
        $mail->Body    = "Please click the following link to reset your password: <a href='{$reset_link}'>Reset Password</a>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
    }
}
