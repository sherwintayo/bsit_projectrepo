<?php
require_once('./config.php');
require_once('./classes/DBConnection.php');
require_once('./classes/SystemSettings.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $token = $_POST['token'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $_SESSION['error'] = "Passwords do not match.";
        header("Location: reset_password.php?token=$token");
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $db = new DBConnection();
    $conn = $db->conn;

    $conn->query("UPDATE users SET password = '$hashed_password', reset_token = NULL, reset_token_expiry = NULL WHERE reset_token = '$token'");
    $_SESSION['success'] = "Password reset successful. You can now log in with your new password.";

    header("Location: login.php");
    exit();
}
?>

