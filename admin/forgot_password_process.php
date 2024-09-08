<?php
require_once('../config.php');
require 'send_password_reset.php';  // Include the send password reset function

$email = $_POST['email'] ?? '';

if (empty($email)) {
    echo json_encode(['message' => 'Please provide an email address.']);
    exit;
}

$query = $conn->prepare("SELECT * FROM users WHERE username = ?");
$query->bind_param("s", $email);
$query->execute();
$result = $query->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['message' => 'Email not found.']);
    exit;
}

$user = $result->fetch_assoc();
$reset_token = bin2hex(random_bytes(32));
$reset_token_hash = hash('sha256', $reset_token);
$expires_at = date('Y-m-d H:i:s', strtotime('+30 minutes'));

// Update user with reset token
$update_query = $conn->prepare("UPDATE users SET reset_token_hash = ?, reset_token_expires_at = ? WHERE id = ?");
$update_query->bind_param('ssi', $reset_token_hash, $expires_at, $user['id']);
$update_query->execute();

// Generate reset link
$reset_link = base_url . "admin/reset_password.php?token=" . $reset_token . "&email=" . urlencode($email);

// Send reset email using the function from send_password_reset.php
$mail_result = send_password_reset($email, $reset_link);

if ($mail_result === true) {
    echo json_encode(['message' => 'Reset link has been sent to your email.']);
} else {
    echo json_encode(['message' => $mail_result]);
}
?>
