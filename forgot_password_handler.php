<?php
require_once('./config.php');
require_once('./classes/DBConnection.php');
require_once('./classes/SystemSettings.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $db = new DBConnection();
    $conn = $db->conn;

    $result = $conn->query("SELECT * FROM users WHERE email = '$email'");
    if ($result->num_rows > 0) {
        $token = bin2hex(random_bytes(50));
        $conn->query("UPDATE users SET reset_token = '$token', reset_token_expiry = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE email = '$email'");

        $reset_link = base_url . "reset_password.php?token=" . $token;
        $subject = "Password Reset Request";
        $message = "Please click the following link to reset your password: $reset_link";
        $headers = "From: no-reply@example.com";

        if (mail($email, $subject, $message, $headers)) {
            $_SESSION['success'] = "Password reset link has been sent to your email.";
        } else {
            $_SESSION['error'] = "Failed to send password reset link.";
        }
    } else {
        $_SESSION['error'] = "No account found with that email.";
    }

    header("Location: login.php");
    exit();
}
?>
