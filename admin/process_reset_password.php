<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $token = $_POST['token'];
    $new_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $token_hash = hash('sha256', $token);

    $sql = "SELECT * FROM users WHERE reset_token_hash = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token_hash);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if ($user) {
        // Update the password
        $sql = "UPDATE users SET password = ?, reset_token_hash = NULL, reset_token_expires_at = NULL WHERE reset_token_hash = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $new_password, $token_hash);
        $stmt->execute();

        echo "Password updated successfully.";
    } else {
        echo "Invalid or expired token.";
    }
}
?>
